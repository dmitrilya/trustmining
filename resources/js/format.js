$(function() {
  $(".format-text").click(function(e) {
    let command = $(this).data("key");
    let active = $(this).hasClass("active");

    $(`.format-text[data-key=${command}]`).removeClass("active");

    if (!active) $(this).addClass("active");

    applyCommand($(this));

    $(this)
      .parent()
      .next()
      .find(".textarea")
      .focus();
  });

  var selSticker, rangeSticker;

  $(".format-text-wrap.format-stickers").click(function() {
    selSticker = document.getSelection();

    let node = selSticker.anchorNode;

    do {
      if (node == null || node.tagName == "FORM") {
        rangeSticker = null;
        return;
      }

      node = node.parentNode;
    } while (node.tagName != "PRE");

    if ($(node).html() != $(this).parents(".position-sticky").next().find("pre").html()) {
      rangeSticker = null;
      return;
    }

    rangeSticker = selSticker.getRangeAt(0);
  });

  $(".emoji-code").click(function() {
    if (rangeSticker) {
      rangeSticker.insertNode(document.createTextNode($(this).html()));
    } else {
      let text = $(this).parents(".position-sticky").next().find("pre");
      text.html(text.html() + $(this).html());
    }
  });

  $.each($(".image_box"), function(index, imageBox) {
    $(imageBox).attr("src", $(imageBox).attr("data-href"));
  });

  $(".add-mentor-image").click(function() {
    let mentorImagesContainer = $(
      `.mentor-images_container[data-question=${$(this).data("question")}]`
    );

    mentorImagesContainer.toggleClass("active");
    mentorImagesContainer.find(".like").css("display", "flex");
    mentorImagesContainer.toggle("active");
  });

  $(".mentor-images_container")
    .find(".type_like")
    .on("click", function() {
      $(".images_container").css("display", "none");
      $(".add-images_container").css("display", "none");
      $(`.like[data-question=${$(this).data("question")}]`).css(
        "display",
        "flex"
      );
    });

  $(".mentor-images_container")
    .find(".type_dislike")
    .on("click", function() {
      $(".images_container").css("display", "none");
      $(".add-images_container").css("display", "none");
      $(`.dislike[data-question=${$(this).data("question")}]`).css(
        "display",
        "flex"
      );
    });

  $(".mentor-images_container")
    .find(".type_support")
    .on("click", function() {
      $(".images_container").css("display", "none");
      $(".add-images_container").css("display", "none");
      $(`.support[data-question=${$(this).data("question")}]`).css(
        "display",
        "flex"
      );
    });

  $(".mentor-images_container")
    .find(".type_plus")
    .on("click", function() {
      $(".images_container").css("display", "none");
      $(`.plus[data-question=${$(this).data("question")}]`).css(
        "display",
        "flex"
      );
    });

  $(".add-comment-image").on("click", function() {
    let questionId = $(this).attr("data-question");
    let href = $(
      `.comment-img[data-question=${$(this).attr("data-question")}]`
    ).val();
    let type = $(
      `.type-select[data-question=${$(this).attr("data-question")}]`
    ).val();

    if (href != "" && type != "") {
      $(".add-comment-images").prop("disabled", true);

      $.ajax({
        url: "/comment-image/store",
        type: "POST",
        data: { href: href, type: type },
        headers: {
          "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content")
        },
        success: response => {
          switch (response["status"]) {
            case 200:
              alert("Картинка добавлена");
              if (type == 1) {
                $(".mentor-images_container")
                  .find(".like")
                  .append(
                    `<img class="image_box comment-image" data-image="${
                      response["id"]
                    }" data-question="${questionId}" src="${href}" alt="image">`
                  );
              } else if (type == 2) {
                $(".mentor-images_container")
                  .find(".dislike")
                  .append(
                    `<img class="image_box comment-image" data-image="${
                      response["id"]
                    }" data-question="${questionId}" src="${href}" alt="image">`
                  );
              }
              $(".add-comment-images").prop("disabled", false);
              break;
            case 404:
              alert("Картикна не найдена");
              $(".add-comment-images").prop("disabled", false);
              break;
            case 500:
              alert("Такая картинка уже существует");
              $(".add-comment-images").prop("disabled", false);
              break;
          }
          $(`.comment-img`).val("");
          $(`.type-select`).val("");
        }
      });
    }
  });

  $(document).on("click", ".comment-image", function() {
    $(".mentor-images_container").toggleClass("active");
    $(".mentor-images_container").toggle("active");
    $(".mentor-images_container")
      .find(".like")
      .css("display", "none");
    $(".mentor-images_container").removeAttr("style");

    let src = $(this).attr("src");
    let dq = $(this).attr("data-question");

    if (src != "") {
      dq = $(this).attr("data-question");

      let ta =
        dq != -1
          ? $(".question")
              .eq($(this).attr("data-question"))
              .find(".textarea[placeholder='Комментарий']")
          : $(".textarea[placeholder='Общий комментарий']");
      ta.append(
        `<img class="w-100 d-block mx-auto" style="max-width:380px" src="${src}">`
      );

      $(`img[src="${src}"]`).one("load", function() {
        ta = ta[0];
        if (ta.scrollHeight > ta.clientHeight) {
          ta.style.height = ta.scrollHeight + "px";
        }
      });
    }
  });

  $("[data-target='#add-comment-video']").click(function() {
    $("#add-comment-video .modal-body button").attr(
      "data-question",
      `${$(this).data("question")}`
    );
  });

  $("#add-comment-video").on("hide.bs.modal", function() {
    $(this)
      .find("input")
      .val("");
  });

  $("#add-comment-video .modal-body button").click(function() {
    let id = $("#comment-video").val(),
      dq;

    if (id != "") {
      let src = `https://www.youtube.com/embed/${id}`;
      dq = $(this).attr("data-question");

      let ta =
        dq != -1
          ? $(".question")
              .eq($(this).attr("data-question"))
              .find(".textarea[placeholder='Комментарий']")
          : $(".textarea[placeholder='Общий комментарий']");
      ta.append(
        `<div class="f-16-9"><iframe width="100%" src="${src}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>`
      );

      $(`[src="${src}"]`).one("load", function() {
        ta = ta[0];
        if (ta.scrollHeight > ta.clientHeight) {
          ta.style.height = ta.scrollHeight + "px";
        }
      });
    }
  });

  $(".textarea").on("selectstart", function(event) {
    setTimeout(function() {
      $(".format-text").removeClass("active");
      let selection = document.getSelection();
      let node = selection.anchorNode;

      if (node == null) return;

      let nodes = [];

      while (node.tagName != "PRE") {
        node = node.parentNode;
        nodes.push(node);
      }

      for (var i = 0; i < nodes.length; i++) {
        node = nodes[i];

        if (node.tagName == "FONT") {
          switch ($(node).attr("color")) {
            case "#16b862":
              $(
                ".format-text[data-key='ForeColor'][data-value='#16b862']"
              ).addClass("active");
              break;
            case "#8800ff":
              $(
                ".format-text[data-key='ForeColor'][data-value='#8800ff']"
              ).addClass("active");
              break;
            case "#ff005b":
              $(
                ".format-text[data-key='ForeColor'][data-value='#ff005b']"
              ).addClass("active");
              break;
            case "#ffffff":
              $(
                ".format-text[data-key='ForeColor'][data-value='#ffffff']"
              ).addClass("active");
              break;
          }
        }

        if ($(node).attr("style") == "background-color: rgb(83, 221, 147);") {
          $(
            ".format-text[data-key='HiliteColor'][data-value='#53dd93']"
          ).addClass("active");
        }

        if ($(node).attr("style") == "background-color: rgb(176, 102, 241);") {
          $(
            ".format-text[data-key='HiliteColor'][data-value='#b066f1']"
          ).addClass("active");
        }

        if ($(node).attr("style") == "background-color: rgb(251, 85, 145);") {
          $(
            ".format-text[data-key='HiliteColor'][data-value='#fb5591']"
          ).addClass("active");
        }

        if (node.tagName == "STRONG" || node.tagName == "B") {
          $(".format-text[data-key='bold']").addClass("active");
        }

        if (node.tagName == "EM" || node.tagName == "I") {
          $(".format-text[data-key='italic']").addClass("active");
        }

        if (node.tagName == "STRIKE") {
          $(".format-text[data-key='strikeThrough']").addClass("active");
        }

        if ($(node).attr("style") == "text-align: left;") {
          $(".format-text[data-key='justifyLeft']").addClass("active");
        } else if ($(node).attr("style") == "text-align: center;") {
          $(".format-text[data-key='justifyCenter']").addClass("active");
        } else if ($(node).attr("style") == "text-align: right;") {
          $(".format-text[data-key='justifyRight']").addClass("active");
        }
      }
    }, 10);

    /*$(".textarea").one('beforeinput', function() {
      $(this).parent().prev().find(".format-text.active").each(function() {
        console.log($(this).data("key"));
        applyCommand($(this));
      });
    });*/
  });
});

function applyCommand(that) {
  let sel, range;
  sel = window.getSelection();
  if (sel.rangeCount && sel.getRangeAt) {
    range = sel.getRangeAt(0);
  }

  if (range) {
    sel.removeAllRanges();
    sel.addRange(range);
  }

  let command = that.data("key");

  let selection = document.getSelection();
  let node = selection.anchorNode;
  let b = false,
    i = false,
    s = false,
    nodes = [];

  do {
    if (node == null || node.tagName == "FORM") return;

    nodes.push(node);
    node = node.parentNode;
  } while (node.tagName != "PRE");

  if ($(node).html() != that.parents(".position-sticky").next().find("pre").html()) return;

  for (var j = 0; j < nodes.length; j++) {
    node = nodes[j];

    if (node.tagName == "STRONG" || node.tagName == "B") {
      b = true;
    } else if (node.tagName == "EM" || node.tagName == "I") {
      i = true;
    } else if (node.tagName == "STRIKE") {
      s = true;
    }
  }

  if (that.hasClass("active")) {
    if (
      !(
        (command == "bold" && b) ||
        (command == "italic" && i) ||
        (command == "strikeThrough" && s)
      )
    )
      document.execCommand(command, false, that.data("value"));
  } else if (command == "ForeColor") {
    document.execCommand("removeFormat", false, "foreColor");
  } else if (command == "HiliteColor") {
    document.execCommand("removeFormat", false, "hiliteColor");
  }

  document.designMode = "off";
}

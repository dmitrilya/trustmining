
import jQuery from 'jquery';
window.$ = jQuery.noConflict();

$(function () {
  $(".format-text").click(function (e) {
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

  $(".emoji-code").click(function () {
    let text = $(this).parents(".position-sticky").next().find("pre");
    text.html(text.html() + $(this).html());
  });

  window.formatAttachMedia = function (type) {
    let urlInput = document.getElementById(`attach-${type}_url`);

    if (urlInput.value != "") {
      let src = urlInput.value, ta = document.querySelector("pre[contenteditable]");
      let media = type == 'img' ? document.createElement('img') : document.createElement('iframe');
      if (type == 'video') {
        media.classList.add('w-full', 'aspect-[4/3]');
        if (src.indexOf('vkvideo') !== -1) {
          let data = src.split('/video')[1].split('_');
          src = `https://vkvideo.ru/video_ext.php?oid=${data[0]}&id=${data[1]}`;
        } else if (src.indexOf('youtube') !== -1) src = `https://www.youtube.com/embed/${src.split('v=')[1]}`;
        else if (src.indexOf('rutube') !== -1) src = `https://rutube.ru/play/embed/${src.split('video/')[1]}`;
      }
      media.src = src;
      media.classList.add('block', 'mx-auto', 'rounded-lg');

      let selection = window.getSelection();

      if (selection.rangeCount === 0 || !ta.contains(selection.getRangeAt(0).commonAncestorContainer)) {
        ta.appendChild(media);
      } else {
        let range = selection.getRangeAt(0);
        range.collapse(false);
        range.insertNode(media);

        selection.removeAllRanges();
        range.setStartAfter(image);
        selection.addRange(range);
      }
    }
  };

  $("[data-target='#add-comment-video']").click(function () {
    $("#add-comment-video .modal-body button").attr(
      "data-question",
      `${$(this).data("question")}`
    );
  });

  $("#add-comment-video").on("hide.bs.modal", function () {
    $(this)
      .find("input")
      .val("");
  });

  $("#add-comment-video .modal-body button").click(function () {
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

      $(`[src="${src}"]`).one("load", function () {
        ta = ta[0];
        if (ta.scrollHeight > ta.clientHeight) {
          ta.style.height = ta.scrollHeight + "px";
        }
      });
    }
  });

  $(".textarea").on("selectstart", function (event) {
    setTimeout(function () {
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

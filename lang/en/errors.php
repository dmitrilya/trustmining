<?php

return [
    'insight' => [
        '404' => [
            'title' => 'Page Not Found',
            'headline' => 'It seems this article has left the media space',
            'paragraphs' => [
                'We searched for the page across all known sources, checked the archives, looked into drafts, and even asked the editorial team. But the article you wanted to open is nowhere to be found.',
                'Perhaps the publication was deleted, moved, or the link is a bit older than we thought. Or maybe this article is so exclusive that it doesn’t exist yet. Try going back or navigating to other materials — there’s definitely something worth reading here.'
            ],
        ],

        '419' => [
            'title' => 'Session Expired',
            'headline' => 'You spent too long reading one article',
            'paragraphs' => [
                "Nothing to worry about — your session just decided you’d finished reading the material and left long ago. Maybe you really got lost in thought, opened twenty more tabs, or simply got distracted by a cup of coffee.",
                "The server can’t read minds and doesn’t know whether you intended to keep reading or had already forgotten about this page. That’s why the session ended. Refresh the page and get back to the material — we’ll pretend no pause ever happened."
            ],
        ],

        '500' => [
            'title' => 'Internal Server Error',
            'headline' => 'The editorial team tried to open the material. The server disagreed',
            'paragraphs' => [
                "We received the request, found the right page, and were almost ready to show you the article. But somewhere between ‘it’s about to load’ and ‘enjoy your reading,’ the server decided to throw a little technical crisis.",
                "We’re still figuring out what exactly happened. Maybe the server was thinking too hard, maybe the article was just too interesting, or maybe it was simply that moment when technology decided to remind us of its human-like nature.",
                "Try refreshing the page in a few seconds. If it works, let’s consider this little editorial mishap never happened."
            ],
        ],
    ],
    'forum' => [
        '404' => [
            'question' => [
                'title' => 'Where did the page go? I’m getting an error when trying to open the forum',
                'text' => "Hi everyone. I’m trying to open a specific forum page, but instead I’m getting an error. At first, I thought it was a problem on my end, but after several refreshes, the situation hasn’t changed.\n\nHas anyone else run into this? Is the server temporarily down, or was the page actually removed? I’d just like to understand if there’s anything I can do from my side, or if I just have to wait.",
                'author' => 'HashWalker',
            ],

            'answer_1' => [
                'text' => "Most likely, the issue is on the server side. If other pages open fine but this specific one keeps throwing an error, it’s unlikely to be related to your browser or internet connection.\n\nI’d wait a bit and try again. If the error persists, then you can contact the administration.",
                'author' => 'HashHunter',
            ],

            'answer_2' => [
                'text' => "I’m also having trouble opening some pages right now. Looks like the server decided to take a moment to contemplate the meaning of life.\n\nTry opening the page again in a few minutes. Sometimes these errors disappear faster than you can figure out what went wrong.",
                'author' => 'ByteNomad',
            ],

            'comment' => [
                'text' => "Just hope the server doesn’t start mining instead of serving the forum.",
                'author' => '0xMiner',
            ],
        ],

        '419' => [
            'question' => [
                'title' => 'The forum logged me out after a long idle period',
                'text' => "I left the forum open while I took care of some other things, and when I came back to continue, I got an error. The page was working fine before that.\n\nIs it normal for the forum to ‘forget’ a user so quickly? Or is there something wrong with my browser? I don’t really want to have to log in again every time I get distracted for a couple of minutes.",
                'author' => 'RigWalker',
            ],

            'answer_1' => [
                'text' => "Most likely, your session simply expired. If you don’t do anything for a long time, the server may assume you’ve left.\n\nRefresh the page or log in again — this usually gets everything working normally. There’s nothing critical going on here.",
                'author' => 'BlockPilot',
            ],

            'answer_2' => [
                'text' => "This happens to me too, especially if I leave the tab open for a few hours.\n\nI wouldn’t worry. The forum hasn’t blocked you; it just figured you’d been away too long and it was time to get reacquainted.",
                'author' => 'MiningBear',
            ],

            'comment' => [
                'text' => "So even the forum needs confirmation that you’re still there. Soon we’ll probably have to click an ‘I’m still mining’ button every hour.",
                'author' => 'NonceMan',
            ],
        ],

        '500' => [
            'question' => [
                'title' => 'Is the site crashing periodically for everyone?',
                'text' => "Lately, I’ve been getting server errors when opening some forum pages. I refresh the page, and sometimes it works, but other times I get the error again.\n\nIs anyone else experiencing this right now? I can’t tell if it’s just my connection acting up or if the server is actually crashing periodically.",
                'author' => 'AsicFox',
            ],

            'answer_1' => [
                'text' => "Yeah, I got this error once too. After refreshing the page, everything worked fine.\n\nLooks like a temporary glitch. If it keeps happening regularly, it’s better to notify the administration so they can check the server logs.",
                'author' => 'BitMechanic',
            ],

            'answer_2' => [
                'text' => "Confirmed — I just got the same error. A minute later, the page opened normally.\n\nMaybe the server just got overwhelmed with too much work at once. Let’s see if it happens again.",
                'author' => 'CoreMiner',
            ],

            'comment' => [
                'text' => "Let’s just hope it’s a simple server glitch and not the moment when the admin decided to test the ‘restart server’ button.",
                'author' => 'VoltMiner',
            ],
        ],
    ],
    'default' => [
        '404' => [
            'title' => 'Announcement of a Missing Page',
            'name' => 'Missing Page',
            'paragraphs' => [
                "For sale: a rare page of the website that was recently located exactly at this address. Its current whereabouts are unknown, and the server claims it never saw it here.",
                "It’s believed that the page may have moved to a different URL on its own, relocated, or simply decided to take a day off. If you know where it is now, please inform the administration."
            ],
            'characteristic_1' => [
                'name' => 'Status',
                'value' => 'Not Found',
            ],
            'characteristic_2' => [
                'name' => 'Location',
                'value' => 'Unknown',
            ],
            'characteristic_3' => [
                'name' => 'Last Known Address',
                'value' => 'This One',
            ],
            'characteristic_4' => [
                'name' => 'Reason for Disappearance',
                'value' => 'Undetermined',
            ],
            'characteristic_5' => [
                'name' => 'Rarity',
                'value' => 'High',
            ],
            'characteristic_6' => [
                'name' => 'Return Guarantee',
                'value' => 'Not Provided',
            ],
            'characteristic_7' => [
                'name' => 'Contents',
                'value' => 'Empty Page',
            ],
            'characteristic_8' => [
                'name' => 'Recommendation',
                'value' => 'Go Back',
            ],
        ],

        '419' => [
            'title' => 'Announcement of an Unexpectedly Expired Session',
            'name' => 'User Session',
            'paragraphs' => [
                "A user session is temporarily missing. It was active just a while ago, but after a prolonged period of inactivity, it stopped responding and apparently went to take a break.",
                "The reasons for its disappearance are unknown. Perhaps the session decided the user had been away for too long and closed the door behind itself. It’s recommended to refresh the page and start the acquaintance anew."
            ],
            'characteristic_1' => [
                'name' => 'Status',
                'value' => 'Expired',
            ],
            'characteristic_2' => [
                'name' => 'Lifespan',
                'value' => 'Limited',
            ],
            'characteristic_3' => [
                'name' => 'Activity',
                'value' => 'None Detected',
            ],
            'characteristic_4' => [
                'name' => 'Cause',
                'value' => 'Prolonged Inactivity',
            ],
            'characteristic_5' => [
                'name' => 'Compatibility',
                'value' => 'Works with Page Refresh',
            ],
            'characteristic_6' => [
                'name' => 'Restart Allowed',
                'value' => 'Yes',
            ],
            'characteristic_7' => [
                'name' => 'Contents',
                'value' => 'User Session',
            ],
            'characteristic_8' => [
                'name' => 'Recommendation',
                'value' => 'Refresh the Page',
            ],
        ],

        '500' => [
            'title' => 'Urgent: Need a Working Server',
            'name' => 'Server with a Temper',
            'paragraphs' => [
                "Attention, visitors: the server is currently showing signs of strong dissatisfaction with the situation. Instead of displaying the requested page, it decided to report that something went wrong internally.",
                "The problem is believed to be on the server’s side. Users are advised to stay calm, not to panic, and try accessing the page a little later. The server is also advised to do the same."
            ],
            'characteristic_1' => [
                'name' => 'Status',
                'value' => 'In a Bad Mood',
            ],
            'characteristic_2' => [
                'name' => 'Operational Capacity',
                'value' => 'Temporarily Reduced',
            ],
            'characteristic_3' => [
                'name' => 'Source of the Problem',
                'value' => 'Server',
            ],
            'characteristic_4' => [
                'name' => 'Repair Complexity',
                'value' => 'Unknown',
            ],
            'characteristic_5' => [
                'name' => 'Warranty',
                'value' => 'Under Review',
            ],
            'characteristic_6' => [
                'name' => 'Reboot',
                'value' => 'Recommended',
            ],
            'characteristic_7' => [
                'name' => 'Contents',
                'value' => 'Server and a Bit of Chaos',
            ],
            'characteristic_8' => [
                'name' => 'Recommendation',
                'value' => 'Try Again Later',
            ],
        ],
        'address' => 'Planet Earth'
    ]
];

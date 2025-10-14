window.pushToastAlert = (text, type) => pushToast('alert', null, null, text, type);

window.pushToastNotif = (title, pretext, text) => pushToast('notif', title, pretext, text);

const pushToast = function (type, title, pretext, text, alert) {
    // <div class="relative inline-block shrink-0 mr-3">
    //     <img class="w-12 h-12 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="Jese Leos image" />
    //     <span class="absolute bottom-0 right-0 inline-flex items-center justify-center w-6 h-6 bg-indigo-600 rounded-full">
    //         <svg class="w-3 h-3 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 18" fill="currentColor">
    //             <path d="M18 4H16V9C16 10.0609 15.5786 11.0783 14.8284 11.8284C14.0783 12.5786 13.0609 13 12 13H9L6.846 14.615C7.17993 14.8628 7.58418 14.9977 8 15H11.667L15.4 17.8C15.5731 17.9298 15.7836 18 16 18C16.2652 18 16.5196 17.8946 16.7071 17.7071C16.8946 17.5196 17 17.2652 17 17V15H18C18.5304 15 19.0391 14.7893 19.4142 14.4142C19.7893 14.0391 20 13.5304 20 13V6C20 5.46957 19.7893 4.96086 19.4142 4.58579C19.0391 4.21071 18.5304 4 18 4Z" fill="currentColor" />
    //             <path d="M12 0H2C1.46957 0 0.960859 0.210714 0.585786 0.585786C0.210714 0.960859 0 1.46957 0 2V9C0 9.53043 0.210714 10.0391 0.585786 10.4142C0.960859 10.7893 1.46957 11 2 11H3V13C3 13.1857 3.05171 13.3678 3.14935 13.5257C3.24698 13.6837 3.38668 13.8114 3.55279 13.8944C3.71889 13.9775 3.90484 14.0126 4.08981 13.996C4.27477 13.9793 4.45143 13.9114 4.6 13.8L8.333 11H12C12.5304 11 13.0391 10.7893 13.4142 10.4142C13.7893 10.0391 14 9.53043 14 9V2C14 1.46957 13.7893 0.960859 13.4142 0.585786C13.0391 0.210714 12.5304 0 12 0Z" fill="currentColor" />
    //         </svg>
    //         <span class="sr-only">Message icon</span>
    //     </span>
    // </div>

    const alertIcons = {
        success: `<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-full dark:bg-green-800 dark:text-green-200">
        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
        </svg>
        <span class="sr-only">Check icon</span>
    </div>`,
        error: `<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-full dark:bg-red-800 dark:text-red-200">
        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
        </svg>
        <span class="sr-only">Error icon</span>
    </div>`,
        warning: `<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-full dark:bg-orange-800 dark:text-orange-200">
        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
        </svg>
        <span class="sr-only">Warning icon</span>
    </div>`
    };

    const toast = document.createElement('div');
    toast.style.opacity = 0;
    toast.className = "w-full p-4 bg-white dark:bg-zinc-900 rounded-lg shadow-lg border border-gray-200 dark:border-zinc-700 transition duration-300";
    toast.role = 'alert';
    toast.innerHTML = type == 'alert' ? `<div class="flex items-center">
    ${alertIcons[alert]}
    <div class="ms-3 text-sm font-normal text-gray-500 dark:text-gray-400">${text}</div>
    <button type="button" onclick="this.parentElement.parentElement.style.opacity = 0;setTimeout(() => { this.parentElement.parentElement.remove() }, 300)"
        class="block ml-auto -mx-1.5 -my-1.5 bg-white dark:bg-zinc-900 justify-center items-center flex-shrink-0 text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 rounded-lg p-1.5 hover:bg-gray-100 dark:hover:border-zinc-800 inline-flex h-8 w-8 dark:text-gray-500" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
    </button>
</div>` : `<div class="flex items-center">
    <span class="text-xs text-gray-400 dark:text-100">${title}</span>
    <button type="button" onclick="this.parentElement.parentElement.style.opacity = 0;setTimeout(() => { this.parentElement.parentElement.remove() }, 300)"
        class="block ml-auto -mx-1.5 -my-1.5 bg-white dark:bg-zinc-900 justify-center items-center flex-shrink-0 text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 rounded-lg p-1.5 hover:bg-gray-100 dark:hover:border-zinc-800 inline-flex h-8 w-8 dark:text-gray-500" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
    </button>
</div>
<div class="font-semibold text-gray-900 mb-1">${pretext}</div>
<div class="text-sm text-gray-500 max-h-10 overflow-hidden">${text}</div>`;

    document.getElementById('toasts').append(toast);

    setTimeout(() => { toast.style.opacity = 1 }, 10);

    setTimeout(() => { toast.style.opacity = 0; setTimeout(() => { toast.remove() }, 300) }, 10000);
}
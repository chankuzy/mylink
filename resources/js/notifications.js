document.addEventListener('DOMContentLoaded', () => {
    generateNotifications();
    initializeFilters();
    initializeActivityGraph();
    initializeRealTimeUpdates();
});

function generateNotifications() {
    const notifications = {
        today: [
            {
                type: 'like',
                user: 'creative_lens',
                action: 'liked your post',
                time: '2 hours ago',
                image: 'random/100x100?nature'
            },
            {
                type: 'comment',
                user: 'artmaster',
                action: 'commented on your post',
                content: 'This is absolutely stunning! 🔥',
                time: '4 hours ago',
                image: 'random/100x100?art'
            },
            {
                type: 'follow',
                user: 'urban_shots',
                action: 'started following you',
                time: '5 hours ago'
            }
        ],
        week: [
            {
                type: 'mention',
                user: 'naturelens',
                action: 'mentioned you in a comment',
                content: 'Hey @johndoe, you might like this!',
                time: '2 days ago',
                image: 'random/100x100?wildlife'
            }
        ],
        earlier: [
            {
                type: 'like',
                user: 'travel_bug',
                action: 'liked your post',
                time: '1 week ago',
                image: 'random/100x100?travel'
            }
        ]
    };

    Object.keys(notifications).forEach(period => {
        const container = document.querySelector(`.notifications-${period}`);
        notifications[period].forEach(notif => {
            container.appendChild(createNotificationElement(notif));
        });
    });
}

function createNotificationElement(notif) {
    const div = document.createElement('div');
    div.className = 'flex items-start gap-4 p-4 rounded-xl hover:bg-[#1c1f3a] transition-colors group';
    
    const iconMap = {
        like: 'ri-heart-fill text-red-500',
        comment: 'ri-chat-1-fill text-blue-500',
        follow: 'ri-user-add-fill text-green-500',
        mention: 'ri-at-line text-purple-500'
    };

    div.innerHTML = `
        <div class="relative">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 p-0.5">
                <div class="w-full h-full rounded-full bg-[#0a0b1e] p-0.5">
                    <img src="https://source.unsplash.com/random/100x100?portrait&${notif.user}" 
                         alt="${notif.user}" 
                         class="w-full h-full rounded-full object-cover">
                </div>
            </div>
            <i class="${iconMap[notif.type]} absolute -bottom-1 -right-1 p-1.5 rounded-full bg-[#161830] group-hover:bg-[#1c1f3a]"></i>
        </div>
        <div class="flex-1">
            <p>
                <span class="font-medium">${notif.user}</span>
                <span class="text-gray-400">${notif.action}</span>
            </p>
            ${notif.content ? `<p class="text-sm text-gray-400 mt-1">${notif.content}</p>` : ''}
            <span class="text-sm text-gray-500 mt-2 block">${notif.time}</span>
        </div>
        ${notif.image ? `
            <div class="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0">
                <img src="https://source.unsplash.com/${notif.image}" 
                     alt="Post" 
                     class="w-full h-full object-cover">
            </div>
        ` : ''}
    `;
    return div;
}

function initializeFilters() {
    const buttons = document.querySelectorAll('.flex.gap-6 button');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            buttons.forEach(btn => {
                btn.classList.remove('border-b-2', 'border-blue-500', 'font-medium');
                btn.classList.add('text-gray-400');
            });
            button.classList.remove('text-gray-400');
            button.classList.add('border-b-2', 'border-blue-500', 'font-medium');
            
            filterNotifications(button.textContent.trim());
        });
    });
}

function filterNotifications(type) {
    const allNotifications = document.querySelectorAll('[class^="notifications-"] > div');
    allNotifications.forEach(notif => {
        const notifType = getNotificationType(notif);
        if (type === 'All' || type.toLowerCase() === notifType) {
            notif.style.display = 'flex';
        } else {
            notif.style.display = 'none';
        }
    });
}

function getNotificationType(notif) {
    if (notif.querySelector('.ri-heart-fill')) return 'likes';
    if (notif.querySelector('.ri-chat-1-fill')) return 'comments';
    if (notif.querySelector('.ri-user-add-fill')) return 'follows';
    if (notif.querySelector('.ri-at-line')) return 'mentions';
    return '';
}

function initializeActivityGraph() {
    const graphContainer = document.getElementById('activityGraph');
    // Create simple bar graph using div elements
    const data = [45, 75, 60, 85, 65, 90, 70];
    const graph = document.createElement('div');
    graph.className = 'flex items-end justify-between h-full';
    
    data.forEach(value => {
        const bar = document.createElement('div');
        bar.className = 'w-8 bg-gradient-to-t from-purple-500 to-blue-500 rounded-t-lg transition-all duration-300 hover:opacity-80';
        bar.style.height = `${value}%`;
        graph.appendChild(bar);
    });
    
    graphContainer.appendChild(graph);
}

function initializeRealTimeUpdates() {
    // Simulate real-time notifications
    setInterval(() => {
        const shouldAdd = Math.random() > 0.7;
        if (shouldAdd) {
            addNewNotification();
        }
    }, 5000);
}

function addNewNotification() {
    const actions = [
        { type: 'like', text: 'liked your post' },
        { type: 'comment', text: 'commented: "Amazing shot! 📸"' },
        { type: 'follow', text: 'started following you' }
    ];
    
    const action = actions[Math.floor(Math.random() * actions.length)];
    const notification = {
        type: action.type,
        user: `user_${Math.floor(Math.random() * 1000)}`,
        action: action.text,
        time: 'Just now',
        image: action.type === 'like' ? 'random/100x100?nature' : null
    };
    
    const element = createNotificationElement(notification);
    element.style.opacity = '0';
    element.style.transform = 'translateY(-10px)';
    element.style.transition = 'all 0.3s ease';
    
    const container = document.querySelector('.notifications-today');
    container.insertBefore(element, container.firstChild);
    
    setTimeout(() => {
        element.style.opacity = '1';
        element.style.transform = 'translateY(0)';
    }, 50);
}
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('notificationsPage');

    render();

    function render(filter) {
        const data = DataStore.load() || {notifications:[]};

        // Attach page-level buttons
        container.querySelector('#markAllReadBtn')?.addEventListener('click', () => {
            data.notifications = data.notifications.map(n => ({...n, read: true}));
            DataStore.save(data);
            render();
            window.app?.pages?.dashboard?.render?.();
        });

        container.querySelector('#deleteAllBtn')?.addEventListener('click', () => {
            if(!confirm('Delete all notifications? This cannot be undone.')) return;
            data.notifications = [];
            DataStore.save(data);
            render();
            window.app?.pages?.dashboard?.render?.();
        });

        container.querySelector('#filterUnreadBtn')?.addEventListener('click', () => {
            const btn = container.querySelector('#filterUnreadBtn');
            const active = btn.dataset.active === '1';
            btn.dataset.active = active ? '0' : '1';
            btn.textContent = active ? 'Show Unread' : 'Show All';
            render(!active ? 'unread' : undefined);
        });

        // Render notifications list
        renderList(filter || (container.querySelector('#filterUnreadBtn')?.dataset.active === '1' ? 'unread' : undefined));
    }

    function renderList(filter) {
        const data = DataStore.load() || {notifications:[]};
        const listContainer = container.querySelector('#notifsPageContainer');
        listContainer.innerHTML = '';

        const list = data.notifications || [];
        const filtered = filter === 'unread' ? list.filter(n => !n.read) : list;
        if(!filtered.length){
            listContainer.innerHTML = '<div class="muted">No notifications</div>';
            return;
        }

        const sorted = filtered.slice().sort((a,b) => new Date(b.datetime) - new Date(a.datetime));
        sorted.forEach(n => {
            const el = document.createElement('div');
            el.className = 'notif';
            el.innerHTML = `
                <div class="left">
                    <strong style="font-size:14px">
                        ${escapeHtml(titleFor(n))}${n.read ? '' : ' <span style="color:var(--unread);font-weight:700"> •</span>'}
                    </strong>
                    <small>${escapeHtml(n.message)}</small>
                </div>
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px">
                    <small class="muted">${fmtDate(n.datetime)}</small>
                    <div>
                        <button class="btn" style="padding:6px 8px;margin-right:6px" data-id="${n.id}" data-action="toggleRead">
                            ${n.read ? 'Mark unread' : 'Mark read'}
                        </button>
                        <button class="btn cancel" style="padding:6px 8px" data-id="${n.id}" data-action="delete">Delete</button>
                    </div>
                </div>
            `;
            listContainer.appendChild(el);
        });

        // Attach individual notification buttons
        listContainer.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = Number(btn.dataset.id);
                const action = btn.dataset.action;
                if(!data) return;

                if(action === 'toggleRead'){
                    data.notifications = data.notifications.map(n => n.id === id ? {...n, read: !n.read} : n);
                    DataStore.save(data);
                    render();
                    window.app?.pages?.dashboard?.render?.();
                } else if(action === 'delete'){
                    data.notifications = data.notifications.filter(n => n.id !== id);
                    DataStore.save(data);
                    render();
                    window.app?.pages?.dashboard?.render?.();
                }
            });
        });
    }

    function titleFor(n){
        switch(n.type){
            case 'reminder': return 'Reminder Sent';
            case 'cancel': return 'Appointment Cancelled';
            case 'no-show': return 'No-show Follow-up';
            case 'payment': return 'Payment Notice';
            default: return 'Notification';
        }
    }
});

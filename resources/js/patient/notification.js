import { Page, DataStore, fmtDate, isSameDay, escapeHtml } from './base.js';

class NotificationPage extends Page {
  render(filter) {
    if (!this.container) {
      console.warn(`NotificationPage: container not found for id "${this.id}"`);
      return;
    }

    const data = DataStore.load() || { notifications: [] };
    const container = this.container;

    container.innerHTML = `
      <h3 id="notifTitle">Recent Notifications</h3>
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
        <div class="muted">Manage and review notifications from the clinic.</div>
        <div style="display:flex;gap:8px;align-items:center">
          <button id="markAllReadBtn" class="btn" style="padding:8px 10px">Mark all read</button>
          <button id="filterUnreadBtn" class="btn cancel" style="padding:8px 10px" data-active="0">Show Unread</button>
          <button id="deleteAllBtn" class="btn cancel" style="padding:8px 10px">Delete all</button>
        </div>
      </div>
      <div id="notifsPageContainer" class="notifsContainer"></div>
    `;

    container.querySelector('#markAllReadBtn')?.addEventListener('click', () => {
      const d = DataStore.load() || { notifications: [] };
      d.notifications = d.notifications.map(n => ({ ...n, read: true }));
      DataStore.save(d);
      this.render();
      this.app.pages.dashboard?.render();
    });

    container.querySelector('#deleteAllBtn')?.addEventListener('click', () => {
      if (!confirm('Delete all notifications? This cannot be undone.')) return;
      const d = DataStore.load() || {};
      d.notifications = [];
      DataStore.save(d);
      this.render();
      this.app.pages.dashboard?.render();
    });

    const filterBtn = container.querySelector('#filterUnreadBtn');
    filterBtn?.addEventListener('click', () => {
      const active = filterBtn.dataset.active === '1';
      filterBtn.dataset.active = active ? '0' : '1';
      filterBtn.textContent = active ? 'Show Unread' : 'Show All';
      this.render(!active ? 'unread' : undefined);
    });

    const activeFilter = filter || (filterBtn?.dataset.active === '1' ? 'unread' : undefined);
    this._renderList(activeFilter);
  }

  _renderList(filter) {
    if (!this.container) return;

    const d = DataStore.load() || { notifications: [] };
    const container = this.container.querySelector('#notifsPageContainer');
    if (!container) {
      console.warn('NotificationPage: #notifsPageContainer not found');
      return;
    }

    container.innerHTML = '';

    const list = d.notifications || [];
    const filtered = filter === 'unread' ? list.filter(n => !n.read) : list;

    if (!filtered.length) {
      container.innerHTML = '<div class="muted">No notifications</div>';
      return;
    }

    const sorted = filtered.slice().sort((a, b) => new Date(b.datetime) - new Date(a.datetime));
    sorted.forEach(n => {
      const el = document.createElement('div');
      el.className = 'notif';
      el.innerHTML = `
        <div class="left">
          <strong style="font-size:14px">${escapeHtml(this._titleFor(n))}${n.read ? '' : ' <span style="color:var(--unread);font-weight:700"> •</span>'}</strong>
          <small>${escapeHtml(n.message)}</small>
        </div>
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px">
          <small class="muted">${fmtDate(n.datetime)}</small>
          <div>
            <button class="btn" style="padding:6px 8px;margin-right:6px" data-id="${n.id}" data-action="toggleRead">${n.read ? 'Mark unread' : 'Mark read'}</button>
            <button class="btn cancel" style="padding:6px 8px" data-id="${n.id}" data-action="delete">Delete</button>
          </div>
        </div>
      `;
      container.appendChild(el);
    });

    container.querySelectorAll('button').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = Number(btn.dataset.id);
        const action = btn.dataset.action;
        const data = DataStore.load();
        if (!data) return;

        if (action === 'toggleRead') {
          data.notifications = data.notifications.map(n => n.id === id ? { ...n, read: !n.read } : n);
        } else if (action === 'delete') {
          data.notifications = data.notifications.filter(n => n.id !== id);
        }

        DataStore.save(data);
        this.render();
        this.app.pages.dashboard?.render();
      });
    });
  }

  _titleFor(n) {
    switch (n.type) {
      case 'reminder': return 'Reminder Sent';
      case 'cancel': return 'Appointment Cancelled';
      case 'no-show': return 'No-show Follow-up';
      case 'payment': return 'Payment Notice';
      default: return 'Notification';
    }
  }
}

export { NotificationPage };

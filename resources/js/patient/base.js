// base.js — shared utilities and base classes

/* DataStore */
class DataStore {
  static key = 'patientData';
  static load() {
    try {
      const raw = localStorage.getItem(DataStore.key);
      return raw ? JSON.parse(raw) : null;
    } catch (e) {
      console.error('Failed to parse patientData', e);
      return null;
    }
  }
  static save(obj) {
    localStorage.setItem(DataStore.key, JSON.stringify(obj));
  }
  static ensureSample() {
    let d = DataStore.load();
    if (d) return d;
    const now = new Date();
    const addDays = (n, h = 9, m = 0) => {
      const x = new Date(now.getFullYear(), now.getMonth(), now.getDate() + n, h, m, 0, 0);
      return x.toISOString();
    };
    d = {
      appointments: [
        { id: 1, title: 'Teeth Cleaning', datetime: addDays(2), confirmed: true, cancelled: false, attended: false },
        { id: 2, title: 'Check-up', datetime: addDays(-3), confirmed: false, cancelled: false, attended: false },
        { id: 3, title: 'Extraction', datetime: addDays(7), confirmed: false, cancelled: true, attended: false }
      ],
      notifications: [
        { id: Date.now() + 1, type: 'cancel', message: 'Your Extraction was cancelled.', datetime: addDays(-1), read: false },
        { id: Date.now() + 2, type: 'payment', message: 'Payment due for previous consult.', datetime: addDays(-2), read: false }
      ],
      bracesColor: 'BLACK',
      email: '',
      phone: '',
      emailNotif: false
    };
    DataStore.save(d);
    return d;
  }
}

/* Utilities */
function fmtDate(dISO) {
  const d = new Date(dISO);
  if (isNaN(d)) return '-';
  return d.toLocaleString(undefined, { month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit' });
}
function isSameDay(aISO, bISO) {
  const a = new Date(aISO), b = new Date(bISO);
  return a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
}
function escapeHtml(text) {
  if (text === undefined || text === null) return '';
  return String(text).replace(/[&<>\"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]));
}

/* Base Page */
class Page {
  constructor(id, title, app) {
    this.id = id;
    this.title = title;
    this.app = app;
    this.container = document.getElementById(id);
  }
  show() {
    document.querySelectorAll('.page').forEach(p => p.style.display = 'none');
    if (this.container) this.container.style.display = 'block';

    const titleEl = document.getElementById('page-title');
    if (titleEl) titleEl.textContent = this.title;
  }
  render() {}
}

export { Page, DataStore, fmtDate, isSameDay, escapeHtml };

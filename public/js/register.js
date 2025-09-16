class BirthdaySelector {
  constructor(monthId, dayId, yearId) {
    this.monthSelect = document.getElementById(monthId);
    this.daySelect = document.getElementById(dayId);
    this.yearSelect = document.getElementById(yearId);

    this.months = [ "January", "February", "March", "April", "May", "June", "July", 
                    "August", "September", "October", "November", "December"];

    this.init();
  }

  init() {
    this.populateMonths();
    this.populateYears();
    this.populateDays(this.monthSelect.value, this.yearSelect.value);

    this.addEventListeners();
  }

  populateMonths() {
    this.months.forEach((m, i) => {
      const opt = new Option(m, i + 1);
      if (i === 0) opt.selected = true;
      this.monthSelect.add(opt);
    });
  }

  populateDays(month, year) {
    this.daySelect.innerHTML = "";
    const daysInMonth = new Date(year, month, 0).getDate();

    for (let d = 1; d <= daysInMonth; d++) {
      const opt = new Option(d, d);
      if (d === 1) opt.selected = true;
      this.daySelect.add(opt);
    }
  }

  populateYears() {
    for (let y = 2025; y >= 1920; y--) {
      const opt = new Option(y, y);
      if (y === 2025) opt.selected = true;
      this.yearSelect.add(opt);
    }
  }

  addEventListeners() {
    this.monthSelect.addEventListener("change", () =>
      this.populateDays(this.monthSelect.value, this.yearSelect.value)
    );
    this.yearSelect.addEventListener("change", () =>
      this.populateDays(this.monthSelect.value, this.yearSelect.value)
    );
  }
}

document.addEventListener("DOMContentLoaded", () => {
  new BirthdaySelector("b_month", "b_day", "b_year");
});

// Dashboard-only JS
(function(){
  const dashboard = document.querySelector(".dashboard-page");
  if(!dashboard) return; // Stop execution if not on dashboard page

  // Navigation switching
  function showPage(pageId){
    // Hide all content inside dashboard
    dashboard.querySelectorAll('.content').forEach(c => c.classList.remove('active'));
    // Remove active from all sidebar links inside dashboard
    dashboard.querySelectorAll('.nav a').forEach(a => a.classList.remove('active'));

    // Show the selected content
    const section = dashboard.querySelector(`#${pageId}`);
    if(section) section.classList.add('active');

    // Highlight sidebar link
    const activeLink = dashboard.querySelector(`.nav a[onclick="showPage('${pageId}')"]`);
    if(activeLink) activeLink.classList.add('active');

    // Update page title
    const titleEl = dashboard.querySelector("#pageTitle");
    if(titleEl) titleEl.textContent = "Admin " + pageId.charAt(0).toUpperCase() + pageId.slice(1);

    // Dynamically load HTML for Patients and Settings
    if(pageId === "patients") loadContent("patients", "patients.html");
    if(pageId === "settings") loadContent("settings", "settings.html");
    if(pageId === "notifications") loadContent("notifications", "notifications.html");
    if(pageId === "appointments") loadContent("appointments", "appointments.html");
  }

  // Dashboard logic
  let appointmentsToday=[], upcomingAppointments=[], cancelledAppointments=[], remindersSent=[];
  let currentCalendar = {year: (new Date()).getFullYear(), month: (new Date()).getMonth()};

  function renderCounts(){
    setCount("todayCount", appointmentsToday.length);
    setCount("upcomingCount", upcomingAppointments.length);
    setCount("cancelledCount", cancelledAppointments.length);
    setCount("reminderCount", remindersSent.length);
  }

  function setCount(id, val){
    const el = dashboard.querySelector(`#${id}`);
    if(!el) return;
    if(val>0){ el.textContent=val; el.classList.remove("hidden"); }
    else { el.textContent=""; el.classList.add("hidden"); }
  }

  function renderCalendar(){
    const cont = dashboard.querySelector("#calendarDays"),
          monthTitle = dashboard.querySelector("#calendarMonth"),
          {year, month} = currentCalendar;

    if(!cont || !monthTitle) return;

    monthTitle.textContent = ["January","February","March","April","May","June","July","August","September","October","November","December"][month]+" "+year;
    cont.innerHTML = "";

    const first = new Date(year, month, 1),
          start = first.getDay(),
          daysInMonth = new Date(year, month+1, 0).getDate();

    let cells = [];
    for(let i=0;i<start;i++) cells.push({empty:true});
    for(let d=1;d<=daysInMonth;d++) cells.push({date:d});
    while(cells.length % 7 !== 0) cells.push({empty:true});

    cells.forEach(c => {
      const el = document.createElement("div");
      if(c.empty){ el.className = "day empty"; }
      else{
        el.className = "day";
        const dn = document.createElement("div");
        dn.className = "date-num";
        dn.textContent = c.date;
        el.appendChild(dn);
      }
      cont.appendChild(el);
    });
  }

  const prevBtn = dashboard.querySelector("#prevMonth");
  const nextBtn = dashboard.querySelector("#nextMonth");
  if(prevBtn) prevBtn.onclick = () => {
    if(currentCalendar.month===0){ currentCalendar.month=11; currentCalendar.year--; }
    else currentCalendar.month--;
    renderCalendar();
  }
  if(nextBtn) nextBtn.onclick = () => {
    if(currentCalendar.month===11){ currentCalendar.month=0; currentCalendar.year++; }
    else currentCalendar.month++;
    renderCalendar();
  }

  async function loadContent(pageId, url){
    const section = dashboard.querySelector(`#${pageId}`);
    if(!section) return;
    try{
      const res = await fetch(url);
      if(!res.ok) throw new Error("Failed to load " + url);
      section.innerHTML = await res.text();
    } catch(err){
      section.innerHTML = `<div class="card"><p>Error loading page: ${err.message}</p></div>`;
    }
  }

  // Initial render
  renderCounts();
  renderCalendar();

  // Expose showPage globally only for sidebar onclick
  window.showPage = showPage;

})();

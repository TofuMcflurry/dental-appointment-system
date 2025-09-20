// Navigation switching
  function showPage(pageId){
  // Hide all content
  document.querySelectorAll('.content').forEach(c=>c.classList.remove('active'));
  // Remove active from all sidebar links
  document.querySelectorAll('.nav a').forEach(a=>a.classList.remove('active'));

  // Show the selected content
  const section = document.getElementById(pageId);
  section.classList.add('active');

  // Highlight sidebar link
  document.querySelector(`.nav a[onclick="showPage('${pageId}')"]`).classList.add('active');

  // Update page title
  document.getElementById("pageTitle").textContent = "Admin " + pageId.charAt(0).toUpperCase() + pageId.slice(1);

  // Dynamically load HTML for Patients and Settings
  if(pageId === "patients") loadContent("patients", "patients.html");
  if(pageId === "settings") loadContent("settings", "settings.html");
  if(pageId === "notifications") loadContent("notifications", "notifications.html");
  if(pageId === "appointments") loadContent("appointments", "appointments.html");
}

  // Dashboard logic
  let appointmentsToday=[],upcomingAppointments=[],cancelledAppointments=[],remindersSent=[];
  let currentCalendar={year:(new Date()).getFullYear(),month:(new Date()).getMonth()};

  function renderCounts(){
    setCount("todayCount",appointmentsToday.length);
    setCount("upcomingCount",upcomingAppointments.length);
    setCount("cancelledCount",cancelledAppointments.length);
    setCount("reminderCount",remindersSent.length);
  }
  function setCount(id,val){
    const el=document.getElementById(id);
    if(val>0){el.textContent=val;el.classList.remove("hidden");}
    else{el.textContent="";el.classList.add("hidden");}
  }

  function renderCalendar(){
    const cont=document.getElementById("calendarDays"),
          monthTitle=document.getElementById("calendarMonth"),
          {year,month}=currentCalendar;

    monthTitle.textContent=["January","February","March","April","May","June","July","August","September","October","November","December"][month]+" "+year;
    cont.innerHTML="";

    const first=new Date(year,month,1),
          start=first.getDay(),
          daysInMonth=new Date(year,month+1,0).getDate();

    let cells=[];
    for(let i=0;i<start;i++) cells.push({empty:true});
    for(let d=1;d<=daysInMonth;d++) cells.push({date:d});
    while(cells.length%7!==0) cells.push({empty:true});

    cells.forEach(c=>{
      const el=document.createElement("div");
      if(c.empty){el.className="day empty";}
      else{
        el.className="day";
        const dn=document.createElement("div");
        dn.className="date-num";
        dn.textContent=c.date;
        el.appendChild(dn);
      }
      cont.appendChild(el);
    });
  }

  document.getElementById("prevMonth").onclick=()=>{
    if(currentCalendar.month===0){currentCalendar.month=11;currentCalendar.year--;}
    else currentCalendar.month--;
    renderCalendar();
  }
  document.getElementById("nextMonth").onclick=()=>{
    if(currentCalendar.month===11){currentCalendar.month=0;currentCalendar.year++;}
    else currentCalendar.month++;
    renderCalendar();
  }

    async function loadContent(pageId, url){
    const section = document.getElementById(pageId);
    try{
      const res = await fetch(url);
      if(!res.ok) throw new Error("Failed to load " + url);
      section.innerHTML = await res.text();
    } catch(err){
      section.innerHTML = `<div class="card"><p>Error loading page: ${err.message}</p></div>`;
    }
  }

  renderCounts();
  renderCalendar();
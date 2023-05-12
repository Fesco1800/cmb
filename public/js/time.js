// Get the current date and format it as a string in the local timezone
var date = new Date();
var option = { year: 'numeric', month: 'long', day: 'numeric', timeZone: 'Asia/Manila' };
var formattedDate = date.toLocaleDateString('en-US', option);

// Set the text of the span element to the formatted date
$('#notification-date').text(formattedDate);

//nav system time    
const timeElement = document.querySelector(".systemtime");
const dateElement = document.querySelector(".systemdate");

/**
 * @param {Date} date
 */
function formatTime(date) {
  const hours12 = date.getHours() % 12 || 12;
  const minutes = date.getMinutes();
  const isAm = date.getHours() < 12;

  return `${hours12.toString().padStart(2, "0")}:${minutes
  .toString()
  .padStart(2, "0")} ${isAm ? "AM" : "PM"}`;
}

/**
 * @param {Date} date
 */
function formatDate(date) {
  const DAYS = [
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday"
    ];
  const MONTHS = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
    ];

  return `${DAYS[date.getDay()]}, ${
    MONTHS[date.getMonth()]
  } ${date.getDate()} ${date.getFullYear()}`;
}

setInterval(() => {
  const now = new Date();

  timeElement.textContent = formatTime(now);
  dateElement.textContent = formatDate(now);
}, 200);


//Greetings


// Set up variables
let container = document.querySelector(".userGreeting");
if (container) {
  let timeNow = new Date().getHours();
  let greeting =
  timeNow >= 0 && timeNow < 12
  ? "Good Morning"
  : timeNow >= 12 && timeNow < 18
  ? "Good Afternoon"
  : "Good Evening";
  let icon = {
    "Good Morning": "fa-solid fa-cloud-sun",
    "Good Afternoon": "fa-regular fa-sun",
    "Good Evening": "fa-solid fa-cloud-moon"
  };
  let iconClass = icon[greeting];
  container.innerHTML = `<h4 style="margin: 0; padding: 0;"><i class="${iconClass}"></i> ${greeting}, </h4>`;

  // CSS styling
  let style = document.createElement("style");
  style.innerHTML = `
    .fa-cloud-sun {
      color: #ffdb00;
    }

    .fa-sun {
      color: #F4E99B;
    }

    .fa-cloud-moon {
      color: gray;
    }
    .fa-cloud-sun.sunrise, .fa-sun.sunrise, .fa-cloud-moon.sunrise {
      
      animation: fadeIn 2s;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(50px); }
      to { opacity: 1; transform: translateY(0); }
    }
  `;
  document.head.appendChild(style);

  // Add animation to the icons
  function animateIcons() {
    try {
      let cloudSunIcon = document.querySelector(".fa-cloud-sun");
      cloudSunIcon.classList.add("sunrise");
    } catch (error) {
      console.log("Cloud sun icon not found");
    }
    
    try {
      let sunIcon = document.querySelector(".fa-sun");
      sunIcon.classList.add("sunrise");
    } catch (error) {
      console.log("Sun icon not found");
    }
    
    try {
      let cloudMoonIcon = document.querySelector(".fa-cloud-moon");
      cloudMoonIcon.classList.add("sunrise");
    } catch (error) {
      console.log("Cloud moon icon not found");
    }

    setTimeout(() => {
      try {
        let cloudSunIcon = document.querySelector(".fa-cloud-sun");
        cloudSunIcon.classList.remove("sunrise");
      } catch (error) {
        console.log("Cloud sun icon not found");
      }
      
      try {
        let sunIcon = document.querySelector(".fa-sun");
        sunIcon.classList.remove("sunrise");
      } catch (error) {
        console.log("Sun icon not found");
      }
      
      try {
        let cloudMoonIcon = document.querySelector(".fa-cloud-moon");
        cloudMoonIcon.classList.remove("sunrise");
      } catch (error) {
        console.log("Cloud moon icon not found");
      }
    }, 4000); // remove "sunrise" class after 5 seconds
  }

  setInterval(animateIcons, 5000); // run animateIcons every 10 seconds (2 seconds animation + 5 seconds pause + 2 seconds animation + 1 second pause)

  animateIcons(); // run the animation immediately on page load
}









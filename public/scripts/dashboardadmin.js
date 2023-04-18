let dashboard = document.getElementById("dashboard");
let user = document.getElementById("user");

let currUrl = window.location.href

if (currUrl.includes("dashboard")){
    dashboard.classList.add("active");
    user.classList.remove("active");
} 
if (currUrl.includes("user")){
    dashboard.classList.remove("active");
    console.log("pcokas");
    user.classList.add("active");
}
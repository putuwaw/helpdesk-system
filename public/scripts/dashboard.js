let ticket = document.getElementById("ticket");
let history = document.getElementById("history");
let home = document.getElementById("home");


let currUrl = window.location.href;
console.log(currUrl);


if (currUrl.includes("ticket")){
    ticket.classList.add("active");
    home.classList.remove("active");
    history.classList.remove("active");
} else if (currUrl.includes("history") || currUrl.includes("detail")){
    history.classList.add("active");
    home.classList.remove("active");
    ticket.classList.remove("active");
}else{
    home.classList.add("active");
    ticket.classList.remove("active");
    history.classList.remove("active");
}
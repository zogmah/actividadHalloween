const voteButtons = document.querySelectorAll(".vote-btn");

voteButtons.forEach((button) => {
    button.addEventListener("click", () => {
        alert("¡Gracias por tu voto!");
       
    });
});

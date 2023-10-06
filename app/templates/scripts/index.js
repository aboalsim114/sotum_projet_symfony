document.addEventListener("DOMContentLoaded", function () {
  const squares = document.querySelectorAll(".blue-square");

  squares.forEach((square, index) => {
    // Écoutez les événements de saisie
    square.addEventListener("input", function () {
      // Assurez-vous qu'il n'y a qu'une seule lettre dans le carré
      if (this.innerText.length > 1) {
        this.innerText = this.innerText.charAt(0);
      }

      // Si ce carré a une lettre, concentrez-vous sur le carré suivant
      if (this.innerText.length === 1 && squares[index + 1]) {
        squares[index + 1].focus();
      }
    });

    // Empêchez la navigation vers le carré suivant si celui-ci est vide
    square.addEventListener("focus", function () {
      if (index > 0 && !squares[index - 1].innerText) {
        squares[index - 1].focus();
      }
    });
  });
});

const myslide = document.querySelectorAll(".myslide"), // Selecciona todos slides
  dot = document.querySelectorAll(".dot"); // Selecciona todos los puntos de navegación
let counter = 1; // Inicializa un contador en 1
slidefun(counter); // Llama a la función para mostrar primero slider
let timer = setInterval(autoSlide, 8000); // Inicia un temporizador para cambiar automáticamente las diapositivas cada 8 segundos

// Función que avanza automáticamente
function autoSlide() {
  counter += 1; // Incrementa el contador
  slidefun(counter); // Llama a la función para mostrar slide atual
}

// Función para avanzar o retroceder manualmente en las diapositivas
function plusSlides(n) {
  counter += n; // Aumenta o disminuye el contador según el valor de 'n'
  slidefun(counter); // Llama a la función para mostrar la diapositiva actual
  resetTimer(); // Reinicia el temporizador
}

// Función para ir a un slide específico mediante los puntos de navegación
function currentSlide(n) {
  counter = n; // Establece el contador en el valor de 'n'
  slidefun(counter); // Llama a la función para mostrar el slide actual
  resetTimer(); // Reinicia el temporizador
}

// Función para reiniciar el temporizador
function resetTimer() {
  clearInterval(timer); // Detiene el temporizador actual
  timer = setInterval(autoSlide, 8000); // Inicia un nuevo temporizador
}

// Función para mostrar una diapositiva específica
function slidefun(n) {
  let i;
  for (i = 0; i < myslide.length; i++) {
    myslide[i].style.display = "none"; // Oculta
  }
  for (i = 0; i < dot.length; i++) {
    dot[i].className = dot[i].className.replace("active", ""); // Elimina la clase "active" de todos los puntos de navegación
  }
  if (n > myslide.length) {
    counter = 1; // Si se supera el ultimo slide, regresa a la primera
  }
  if (n < 1) {
    counter = myslide.length; // Si se retrocede desde el primero
  }
  myslide[counter - 1].style.display = "block"; // Muestra slide actual
  dot[counter - 1].className += " active"; // Marca como activo el punto de navegación correspondiente
}

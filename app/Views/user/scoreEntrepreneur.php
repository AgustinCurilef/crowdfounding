<main class="app-main background-impulsa">
    <div class="profile-container">
        <div class="profile-header">
            <img src="<?= base_url('user/showImage/' . session()->get('ID_USUARIO')); ?>" alt="Foto de Perfil" class="profile-photo">
            <h3 class="profile-name"><?= esc($user_name) ?></h3>

        </div>

        <div class="rating-section">
            <h5>Puntuación Promedio</h5>
            <div class="d-flex justify-content-center align-items-center">
                <div class="star-rating average-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <span class="ms-2 average-rating">(4.2)</span>
                <span class="ms-2 text-muted"><span id="vote-count">150</span> </span> <!-- Aquí agregas la cantidad de votos -->
            </div>


            <h5 class="mt-4">Puntúa a este Emprendedor</h5>
            <div id="user-rating" class="d-flex justify-content-center">
                <div class="star-rating" data-value="1">
                    <i class="fas fa-star"></i>
                </div>
                <div class="star-rating" data-value="2">
                    <i class="fas fa-star"></i>
                </div>
                <div class="star-rating" data-value="3">
                    <i class="fas fa-star"></i>
                </div>
                <div class="star-rating" data-value="4">
                    <i class="fas fa-star"></i>
                </div>
                <div class="star-rating" data-value="5">
                    <i class="fas fa-star"></i>
                </div>
            </div>

            <button id="submit-rating" class="btn submit-rating mt-3">
                Enviar Calificación
            </button>
        </div>
    </div>
</main>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const userRatingStars = document.querySelectorAll("#user-rating .star-rating");
        let selectedRating = 0; // Almacena el valor seleccionado

        // Suponiendo que esta variable contenga el número de votos
        const voteCount = 10; // Cambia este valor según los datos que tengas
        // Establecer el número de votos en el elemento

        document.getElementById('vote-count').textContent = `(${voteCount} votos)`;
        userRatingStars.forEach(star => {
            // Resalta al pasar el cursor
            star.addEventListener("mouseover", () => {
                highlightStars(star.dataset.value);
            });

            // Resetea al mover el cursor fuera
            star.addEventListener("mouseout", () => {
                resetStars();
                if (selectedRating > 0) highlightStars(selectedRating, true); // Mantiene las estrellas seleccionadas
            });

            // Fija la selección al hacer clic
            star.addEventListener("click", () => {
                selectedRating = star.dataset.value;
                resetStars();
                highlightStars(selectedRating, true);
            });
        });

        // Resalta las estrellas hasta el valor dado
        function highlightStars(value, permanent = false) {
            userRatingStars.forEach(star => {
                if (parseInt(star.dataset.value) <= parseInt(value)) {
                    star.classList.add(permanent ? "active" : "hover");
                }
            });
        }

        // Resetea todas las estrellas
        function resetStars() {
            userRatingStars.forEach(star => {
                star.classList.remove("hover", "active");
            });
        }
    });
</script>
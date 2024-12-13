<main class="app-main background-impulsa">
    <div class="profile-container">
        <div class="profile-header">
            <img src="<?= base_url('user/showImage/' . esc($emprendedor['ID_USUARIO'])); ?>" alt="Foto de Perfil" class="profile-photo">
            <h3 class="profile-name"><?= esc($emprendedor['USERNAME']) ?></h3>

        </div>

        <div class="rating-section">
            <h5>Puntuación Promedio</h5>
            <div class="d-flex justify-content-center align-items-center">
                <div class="star-rating average-rating" id = "starScore">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <span class="ms-2 average-rating" id = "numScore" onload="updateStarRating()"></span>
                <span class="ms-2 text-muted"><span id="vote-count"></span> </span> <!-- Aquí agregas la cantidad de votos -->
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
    function updateStarRating() {
        const stars = document.querySelectorAll('#starScore i');
        const scoreStored = <?= json_encode($statistics['promedio']); ?>; // Promedio del backend
        stars.forEach((star, index) => {
            if (index < Math.floor(scoreStored)) {
                star.classList.remove('far');
                star.classList.add('fas');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
            }
        });
    }
  
    let selectedRating = <?= json_encode($mi_voto); ?>; // Variable global fuera del evento
    document.addEventListener("DOMContentLoaded", () => {
        const userRatingStars = document.querySelectorAll("#user-rating .star-rating");
        const scoreStored = <?= json_encode($statistics['promedio']); ?> ?? 0;
        const voteCount = <?= json_encode($statistics['totalVotos']); ?>; 
        updateStarRating(); // Llama a la función para actualizar las estrellas promedio
        highlightStars(selectedRating, true);
        document.getElementById('numScore').textContent = `(${scoreStored})`;
        document.getElementById('vote-count').textContent = `${voteCount} votos`;
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
    document.getElementById('submit-rating').addEventListener('click', () => {

        const idUsuarioPuntuador = <?= json_encode($idUsuario); ?>; // ID del usuario que vota
        const idUsuarioPuntuado = <?= json_encode($emprendedor['ID_USUARIO']); ?>; // ID del emprendedor
        const puntaje = selectedRating; // Puntuación seleccionada
        
        if (selectedRating == 0) {
            alert('Por favor, selecciona una puntuación antes de enviar.');
            return;
        }

        if (idUsuarioPuntuador == idUsuarioPuntuado) {
            alert('No puedes puntuarte a ti mismo.');
            return;
        }

        console.log('Datos a enviar:', {
            puntuador: idUsuarioPuntuador,
            puntuado: idUsuarioPuntuado,
            puntaje: selectedRating
        });

        fetch('<?= base_url('/rating/submit'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    puntuador: idUsuarioPuntuador,
                    puntuado: idUsuarioPuntuado,
                    puntaje: selectedRating
                })
            })
        location.reload();
    });
</script>
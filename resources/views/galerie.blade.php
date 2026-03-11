@extends('layouts.app')

@section('title', 'Galerie')

@section('content')
    <!-- Section Hero avec image pleine hauteur -->
    <section class="w-full h-[200px] bg-cover bg-center bg-no-repeat flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="main-title text-5xl sm:text-6xl font-bold text-black drop-shadow-lg mb-4">
                Calan'Couleurs en photos
            </h1>
            <p class="main-title text-xl sm:text-2xl font-medium text-black drop-shadow-md">
                Édition {{ $selectedYear }}
            </p>
        </div>
    </section>



<div class="gallery-container main-title">
<form action="{{ route('galerie.index') }}" method="GET">

    <label for="years">Choix de l'année :</label>
    <select onchange="this.form.submit()" name="year" id="year">
        @foreach($archivedYears as $year)
            <option value="{{ $year }}" {{ request('year', $selectedYear) == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endforeach
    </select>

</form>


<div class="mosaic" role="list">
    @foreach ($images as $image)
        <div class="mosaic-item" role="listitem">
            <button 
                class="mosaic-btn"
                onclick="openModal('{{ asset($image) }}')"
                aria-label="Ouvrir l'image {{ $loop->index + 1 }} en plein écran"
            >
                <img src="{{ asset($image) }}" alt="Image galerie {{ $loop->index + 1 }}">
            </button>
        </div>
    @endforeach
</div>

<div id="imageModal" class="modal" role="dialog" aria-modal="true" aria-label="Visionneuse d'images">
    <button class="close" onclick="closeModal()" aria-label="Fermer">&times;</button>
    <button class="nav-btn nav-prev" onclick="navigate(-1)" aria-label="Image précédente">&#8249;</button>
    <img class="modal-content" id="modalImage" alt="">
    <button class="nav-btn nav-next" onclick="navigate(1)" aria-label="Image suivante">&#8250;</button>
    <span class="modal-counter" id="modalCounter"></span>
</div>

<script>


const images = @json($images->values());
let currentIndex = 0;

function openModal(imgSrc) {
    currentIndex = images.findIndex(img => imgSrc.includes(img));
    updateModal();
    document.getElementById("imageModal").style.display = "block";
}

function updateModal() {
    const src = "{{ asset('') }}" + images[currentIndex];
    document.getElementById("modalImage").src = src;
    document.getElementById("modalCounter").textContent = (currentIndex + 1) + " / " + images.length;
}

function navigate(direction) {
    currentIndex = (currentIndex + direction + images.length) % images.length;
    updateModal();
    event.stopPropagation();
}

function closeModal() {
    document.getElementById("imageModal").style.display = "none";
}

document.addEventListener("keydown", (e) => {
    const modal = document.getElementById("imageModal");
    if (modal.style.display !== "block") return;

    if (e.key === "ArrowRight") navigate(1);
    if (e.key === "ArrowLeft")  navigate(-1);
    if (e.key === "Escape")     closeModal();
});
</script>

<style>

/* Main container */
.gallery-container {
    max-width: 90%;
    margin: 0 auto;
    padding: 20px;
}

.main-title {
    color: #8F1E98;
}

/* From */
form {
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}

form label {
    font-weight: 600;
}

form select {
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
}

form button {
    padding: 6px 16px;
    background-color: #ffffff;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s;
}

form button:hover {
    background-color: #ffffff;
}

/* Mosaic */
.mosaic {
    columns: 4 280px;
    column-gap: 20px;
}

.mosaic-item {
    break-inside: avoid;
    margin-bottom: 12px;
    border-radius: 8px;
}

.mosaic-item img {
    width: 100%;
    display: block;
    cursor: pointer;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.mosaic-item img:hover {
    transform: scale(1.02);
    opacity: 0.9;
}

/* Focus for tab navigation */
.mosaic-btn {
    padding: 0;
    border: none;
    background: none;
    cursor: pointer;
    display: block;
    width: 100%;
}

.mosaic-btn:focus-visible {
    outline: 3px solid #ffffff;
    outline-offset: 3px;
}

.mosaic-btn img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.15);
    border: none;
    color: white;
    font-size: 56px;
    line-height: 1;
    padding: 8px 18px;
    cursor: pointer;
    border-radius: 6px;
    transition: background 0.2s;
    user-select: none;
}

.nav-btn:hover, .nav-btn:focus-visible {
    background: rgba(255,255,255,0.3);
    outline: 2px solid white;
}

.nav-prev { left: 16px; }
.nav-next { right: 16px; }

/* Modal */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.85);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.modal[style*="display: block"] {
    display: flex !important;
}

.modal-content {
    max-width: 90vw;
    max-height: 90vh;
    border-radius: 8px;
    object-fit: contain;
    box-shadow: 0 8px 40px rgba(0,0,0,0.5);
}

.modal-counter {
    position: absolute;
    bottom: 16px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 14px;
    background: rgba(0,0,0,0.4);
    padding: 4px 12px;
    border-radius: 20px;
}

.close {
    position: absolute;
    top: 18px;
    right: 28px;
    font-size: 36px;
    color: white;
    cursor: pointer;
    background: none;
    border: none;
    line-height: 1;
    user-select: none;
}

.close:hover {
    color: #f87171;
}
</style>

@endsection
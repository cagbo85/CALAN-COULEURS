document.addEventListener("DOMContentLoaded", () => {
    const popup = document.getElementById("merchPopup");
    const closeBtn = document.getElementById("closeMerchPopup");
    const closeBtnSecondary = document.getElementById("closeMerchPopupSecondary");

    if (popup && closeBtn) {
        if (!sessionStorage.getItem("merchPopupClosed")) {
            popup.classList.remove("hidden");
        }

        const closePopup = () => {
            popup.classList.add("hidden");
            sessionStorage.setItem("merchPopupClosed", "true");
        };

        closeBtn.addEventListener("click", closePopup);

        if (closeBtnSecondary) {
            closeBtnSecondary.addEventListener("click", closePopup);
        }
    }
});

class TableFilter {
    constructor(tableId, options = {}) {
        this.table = document.getElementById(tableId);
        this.tbody = this.table.querySelector("tbody");
        this.rows = Array.from(this.tbody.querySelectorAll("tr"));
        this.filters = {};
        this.debounceTimer = null;
        this.debounceDelay = options.debounceDelay || 300;

        // Configuration des colonnes à filtrer
        this.columnMappings = {
            search: [0, 1], // Colonnes nom et style
            day: [2], // Colonne programmation
            status: [4], // Colonne statut
        };

        this.init();
    }

    init() {
        this.bindEvents();
        this.createNoResultsRow();
    }

    bindEvents() {
        // Filtre de recherche avec debounce
        const searchInput = document.getElementById("search-input");
        if (searchInput) {
            searchInput.addEventListener("input", (e) => {
                this.debounceFilter(() => {
                    this.filters.search = e.target.value.toLowerCase().trim();
                    this.applyFilters();
                });
            });
        }

        // Filtre par jour
        const daySelect = document.getElementById("day-select");
        if (daySelect) {
            daySelect.addEventListener("change", (e) => {
                this.filters.day = e.target.value.toLowerCase();
                this.applyFilters();
            });
        }

        // Filtre par statut
        const statusSelect = document.getElementById("status-select");
        if (statusSelect) {
            statusSelect.addEventListener("change", (e) => {
                this.filters.status = e.target.value;
                this.applyFilters();
            });
        }

        // Bouton reset
        const resetBtn = document.getElementById("reset-filters");
        if (resetBtn) {
            resetBtn.addEventListener("click", () => {
                this.resetFilters();
            });
        }
    }

    debounceFilter(callback) {
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(callback, this.debounceDelay);
    }

    applyFilters() {
        let visibleCount = 0;

        this.rows.forEach((row) => {
            const isVisible = this.isRowVisible(row);
            row.style.display = isVisible ? "" : "none";
            if (isVisible) visibleCount++;
        });

        this.updateResultsCount(visibleCount);
        this.toggleNoResultsMessage(visibleCount === 0);
    }

    isRowVisible(row) {
        const cells = row.querySelectorAll("td");

        // Filtre de recherche (nom et style)
        if (this.filters.search) {
            const searchColumns = this.columnMappings.search;
            const searchMatch = searchColumns.some((colIndex) => {
                const cell = cells[colIndex];
                if (!cell) return false;
                const text = this.getCellText(cell).toLowerCase();
                return text.includes(this.filters.search);
            });
            if (!searchMatch) return false;
        }

        // Filtre par jour
        if (this.filters.day) {
            const dayCell = cells[this.columnMappings.day[0]];
            if (dayCell) {
                const dayText = this.getCellText(dayCell).toLowerCase();
                if (!dayText.includes(this.filters.day)) return false;
            }
        }

        // Filtre par statut
        if (this.filters.status !== undefined && this.filters.status !== "") {
            const statusCell = cells[this.columnMappings.status[0]];
            if (statusCell) {
                const isActive =
                    statusCell.querySelector(".bg-green-100") !== null;
                const expectedStatus = this.filters.status === "1";
                if (isActive !== expectedStatus) return false;
            }
        }

        return true;
    }

    getCellText(cell) {
        // Extrait le texte en ignorant les balises HTML
        return cell.textContent || cell.innerText || "";
    }

    updateResultsCount(count) {
        const countElement = document.getElementById("results-count");
        if (countElement) {
            const total = this.rows.length;
            countElement.textContent = `${count} résultat${
                count > 1 ? "s" : ""
            } sur ${total}`;
        }
    }

    createNoResultsRow() {
        this.noResultsRow = document.createElement("tr");
        this.noResultsRow.id = "no-results-row";
        this.noResultsRow.style.display = "none";
        this.noResultsRow.innerHTML = `
            <td colspan="6" class="px-6 py-12 text-center">
                <div class="flex flex-col items-center">
                    <i class="fas fa-search text-gray-400 text-3xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun résultat trouvé</h3>
                    <p class="text-gray-500">Essayez de modifier vos critères de recherche</p>
                </div>
            </td>
        `;
        this.tbody.appendChild(this.noResultsRow);
    }

    toggleNoResultsMessage(show) {
        if (this.noResultsRow) {
            this.noResultsRow.style.display = show ? "" : "none";
        }
    }

    resetFilters() {
        // Reset des valeurs
        this.filters = {};

        // Reset des inputs
        const searchInput = document.getElementById("search-input");
        if (searchInput) searchInput.value = "";

        const daySelect = document.getElementById("day-select");
        if (daySelect) daySelect.value = "";

        const statusSelect = document.getElementById("status-select");
        if (statusSelect) statusSelect.value = "";

        // Réafficher toutes les lignes
        this.rows.forEach((row) => {
            row.style.display = "";
        });

        this.updateResultsCount(this.rows.length);
        this.toggleNoResultsMessage(false);
    }

    // Méthode pour ajouter des filtres personnalisés
    addCustomFilter(name, columnIndices, filterFunction) {
        this.columnMappings[name] = columnIndices;
        // Vous pouvez étendre cette méthode selon vos besoins
    }
}

// Auto-initialisation au chargement de la page
document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("artistes-table")) {
        const tableFilter = new TableFilter("artistes-table", {
            debounceDelay: 250, // Délai optimisé pour la performance
        });

        // Rendre disponible globalement si nécessaire
        window.artistesFilter = tableFilter;
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("searchForm");
    if (!form) return;
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const query = document.getElementById("searchInput").value;
        // Use data-url attribute from form
        const url = form.getAttribute("data-url");
        // Show loading spinner
        const spinner = document.getElementById("loadingSpinner");
        if (spinner) {
            spinner.classList.remove("hidden");
            spinner.classList.add("flex");
        }
        fetch(url + "?query=" + encodeURIComponent(query), {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                const section = document.getElementById("resultsSection");
                const container = document.getElementById("resultsContainer");
                // Clear previous results
                container.replaceChildren();
                if (data.length > 0) {
                    data.forEach((pasien) => {
                        const card = document.createElement("div");
                        card.className =
                            "p-6 bg-white rounded-lg shadow border border-gray-200 max-w-sm w-full";
                        const title = document.createElement("h3");
                        title.className = "font-bold text-lg mb-2";
                        title.textContent = pasien.nama;
                        card.appendChild(title);
                        const nik = document.createElement("p");
                        nik.textContent = "NIK: " + pasien.nik;
                        card.appendChild(nik);
                        const dob = document.createElement("p");
                        const dateOnly = pasien.tanggal_lahir.split("T")[0];
                        dob.textContent = "Tanggal Lahir: " + dateOnly;
                        card.appendChild(dob);
                        const gender = document.createElement("p");
                        const jk =
                            pasien.jenis_kelamin.charAt(0).toUpperCase() +
                            pasien.jenis_kelamin.slice(1);
                        gender.textContent = "Jenis Kelamin: " + jk;
                        card.appendChild(gender);
                        container.appendChild(card);
                    });
                } else {
                    const noData = document.createElement("p");
                    noData.className = "text-gray-600";
                    noData.textContent = "Tidak ada data ditemukan.";
                    container.appendChild(noData);
                }
                section.classList.remove("hidden");
                // Hide loading spinner
                if (spinner) {
                    spinner.classList.remove("flex");
                    spinner.classList.add("hidden");
                }
            })
            .catch((error) => {
                console.error(error);
                const section = document.getElementById("resultsSection");
                const container = document.getElementById("resultsContainer");
                container.replaceChildren();
                const errMsg = document.createElement("p");
                errMsg.className = "text-red-600";
                errMsg.textContent = "Gagal memuat data.";
                container.appendChild(errMsg);
                section.classList.remove("hidden");
                // Hide loading spinner
                if (spinner) {
                    spinner.classList.remove("flex");
                    spinner.classList.add("hidden");
                }
            });
    });
});

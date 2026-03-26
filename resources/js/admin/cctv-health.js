const initCctvHealthSummary = () => {
    const pageRoot = document.getElementById("cctv-health-page");
    if (!pageRoot) {
        return;
    }

    const summaryUrl = pageRoot.dataset.summaryUrl;
    if (!summaryUrl) {
        return;
    }

    const totalEl = document.getElementById("stat-total");
    const onlineEl = document.getElementById("stat-online");
    const degradedEl = document.getElementById("stat-degraded");
    const offlineEl = document.getElementById("stat-offline");
    const unknownEl = document.getElementById("stat-unknown");

    const loadHealthSummary = () => {
        fetch(summaryUrl)
            .then((response) => response.json())
            .then((data) => {
                if (totalEl) totalEl.textContent = data.total_cameras ?? "-";
                if (onlineEl) onlineEl.textContent = data.online ?? "-";
                if (degradedEl) degradedEl.textContent = data.degraded ?? "-";
                if (offlineEl) offlineEl.textContent = data.offline ?? "-";
                if (unknownEl) unknownEl.textContent = data.unknown ?? "-";
            })
            .catch((error) => {
                console.error("Error loading health summary:", error);
            });
    };

    loadHealthSummary();
    setInterval(loadHealthSummary, 30000);
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCctvHealthSummary);
} else {
    initCctvHealthSummary();
}


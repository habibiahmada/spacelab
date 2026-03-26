const initCctvIndexMonitor = () => {
    const previewVideos = Array.from(document.querySelectorAll(".webcam-preview-video"));
    const monitorButtons = Array.from(document.querySelectorAll(".open-monitor-btn"));

    const modal = document.getElementById("monitor-modal");
    const closeBtn = document.getElementById("monitor-close-btn");
    const roomNameEl = document.getElementById("monitor-room-name");
    const buildingNameEl = document.getElementById("monitor-building-name");
    const infoClassEl = document.getElementById("monitor-info-class");
    const infoMajorEl = document.getElementById("monitor-info-major");
    const infoPeriodEl = document.getElementById("monitor-info-period");
    const infoEventEl = document.getElementById("monitor-info-event");
    const emptyState = document.getElementById("monitor-empty-state");
    const ipWrapper = document.getElementById("monitor-ip-wrapper");
    const ipFrame = document.getElementById("monitor-ip-frame");
    const webcamWrapper = document.getElementById("monitor-webcam-wrapper");
    const webcamVideo = document.getElementById("monitor-webcam-video");
    const webcamOverlay = document.getElementById("monitor-webcam-overlay");

    let webcamStream = null;
    let webcamPromise = null;

    const getPreviewOverlay = (videoEl) => videoEl.parentElement?.querySelector(".webcam-preview-overlay");

    const showOverlay = (overlayEl, text) => {
        if (!overlayEl) {
            return;
        }

        if (typeof text === "string") {
            overlayEl.textContent = text;
        }

        overlayEl.classList.remove("hidden");
    };

    const hideOverlay = (overlayEl) => {
        if (!overlayEl) {
            return;
        }

        overlayEl.classList.add("hidden");
    };

    const webcamErrorMessage = (error) => {
        if (error?.name === "NotAllowedError") {
            return "Izin kamera ditolak. Izinkan kamera di browser untuk monitoring.";
        }
        if (error?.name === "NotFoundError") {
            return "Perangkat webcam tidak ditemukan.";
        }
        if (error?.name === "NotReadableError") {
            return "Webcam sedang dipakai aplikasi lain.";
        }

        return "Webcam tidak bisa diakses.";
    };

    const assignStreamToVideo = (videoEl, overlayEl) => {
        if (!videoEl || !webcamStream) {
            return;
        }

        videoEl.srcObject = webcamStream;
        hideOverlay(overlayEl);
        videoEl.play().catch(() => {
            showOverlay(overlayEl, "Preview webcam tertahan oleh browser.");
        });
    };

    const assignStreamToAllPreviews = () => {
        previewVideos.forEach((videoEl) => {
            assignStreamToVideo(videoEl, getPreviewOverlay(videoEl));
        });
    };

    const ensureWebcamStream = () => {
        if (webcamStream) {
            return Promise.resolve(webcamStream);
        }

        if (webcamPromise) {
            return webcamPromise;
        }

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            return Promise.reject(new Error("Browser tidak mendukung getUserMedia."));
        }

        webcamPromise = navigator.mediaDevices
            .getUserMedia({ video: true, audio: false })
            .then((stream) => {
                webcamStream = stream;
                assignStreamToAllPreviews();
                return stream;
            })
            .finally(() => {
                webcamPromise = null;
            });

        return webcamPromise;
    };

    const closeModal = () => {
        if (!modal) {
            return;
        }

        modal.classList.add("hidden");
        modal.classList.remove("flex");

        if (ipFrame) {
            ipFrame.src = "";
        }

        if (webcamVideo) {
            webcamVideo.srcObject = null;
        }
    };

    const resetModalContent = () => {
        emptyState?.classList.add("hidden");
        ipWrapper?.classList.add("hidden");
        webcamWrapper?.classList.add("hidden");

        if (ipFrame) {
            ipFrame.src = "";
        }

        showOverlay(webcamOverlay, "Mengaktifkan webcam...");
    };

    const openModalForButton = (button) => {
        if (!modal) {
            return;
        }

        const roomName = button.dataset.room || "Pantau Kamera";
        const buildingName = button.dataset.building || "-";
        const cameraType = button.dataset.cameraType || "none";
        const streamUrl = button.dataset.streamUrl || "";
        const isCameraActive = button.dataset.cameraActive === "1";
        const historyClass = button.dataset.historyClass || "-";
        const historyMajor = button.dataset.historyMajor || "-";
        const historyPeriod = button.dataset.historyPeriod || "-";
        const historyEvent = button.dataset.historyEvent || "-";

        if (roomNameEl) {
            roomNameEl.textContent = roomName;
        }

        if (buildingNameEl) {
            buildingNameEl.textContent = buildingName;
        }

        if (infoClassEl) {
            infoClassEl.textContent = historyClass;
        }

        if (infoMajorEl) {
            infoMajorEl.textContent = historyMajor;
        }

        if (infoPeriodEl) {
            infoPeriodEl.textContent = historyPeriod;
        }

        if (infoEventEl) {
            infoEventEl.textContent = historyEvent;
        }

        resetModalContent();

        if (!isCameraActive || cameraType === "none") {
            emptyState?.classList.remove("hidden");
        } else if (cameraType === "ip_camera" && streamUrl) {
            ipWrapper?.classList.remove("hidden");
            if (ipFrame) {
                ipFrame.src = streamUrl;
            }
        } else if (cameraType === "webcam") {
            webcamWrapper?.classList.remove("hidden");
            ensureWebcamStream()
                .then(() => {
                    assignStreamToVideo(webcamVideo, webcamOverlay);
                })
                .catch((error) => {
                    showOverlay(webcamOverlay, webcamErrorMessage(error));
                });
        } else {
            emptyState?.classList.remove("hidden");
        }

        modal.classList.remove("hidden");
        modal.classList.add("flex");
    };

    if (previewVideos.length) {
        ensureWebcamStream().catch((error) => {
            const message = webcamErrorMessage(error);
            previewVideos.forEach((videoEl) => {
                showOverlay(getPreviewOverlay(videoEl), message);
            });
        });
    }

    monitorButtons.forEach((button) => {
        button.addEventListener("click", () => openModalForButton(button));
    });

    closeBtn?.addEventListener("click", closeModal);

    modal?.addEventListener("click", (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && modal?.classList.contains("flex")) {
            closeModal();
        }
    });

    window.addEventListener("beforeunload", () => {
        if (!webcamStream) {
            return;
        }

        webcamStream.getTracks().forEach((track) => track.stop());
        webcamStream = null;
    });
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCctvIndexMonitor);
} else {
    initCctvIndexMonitor();
}

// CCTV Playback Timeline & Player
document.addEventListener('DOMContentLoaded', function() {
    const timelineGrid = document.getElementById('timeline-grid');
    const timelineHourLabels = document.getElementById('timeline-hour-labels');
    const timelineLoading = document.getElementById('timeline-loading');
    const timelineSummary = document.getElementById('timeline-summary');
    const playbackVideo = document.getElementById('playback-video');
    const playerPlaceholder = document.getElementById('player-placeholder');
    const segmentInfo = document.getElementById('segment-info');
    const segmentStateBadge = document.getElementById('segment-state-badge');
    const segmentEmptyHint = document.getElementById('segment-empty-hint');
    const segmentStart = document.getElementById('segment-start');
    const segmentEnd = document.getElementById('segment-end');
    const segmentDuration = document.getElementById('segment-duration');
    const segmentSize = document.getElementById('segment-size');
    const segmentMode = document.getElementById('segment-mode');
    const segmentCodec = document.getElementById('segment-codec');
    const segmentResolution = document.getElementById('segment-resolution');
    const segmentIntegrity = document.getElementById('segment-integrity');
    const selectedRoomId = window.roomId ?? null;
    const selectedDate = window.date ?? null;

    if (!timelineGrid || !timelineLoading || !playbackVideo || !playerPlaceholder || !segmentInfo) {
        return;
    }

    let segments = [];
    let events = [];
    let selectedHour = null;

    // Load segments and events
    function loadTimeline() {
        if (!selectedRoomId || !selectedDate) return;

        timelineLoading.classList.remove('hidden');
        if (timelineSummary) {
            timelineSummary.textContent = 'Memuat data timeline...';
        }
        
        const url = new URL('/admin/cctv/playback/segments', window.location.origin);
        url.searchParams.append('room_id', selectedRoomId);
        url.searchParams.append('date', selectedDate);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                segments = data.segments || [];
                events = data.events || [];
                renderTimeline();
                renderHourLabels();
                updateTimelineSummary();
                timelineLoading.classList.add('hidden');
            })
            .catch(error => {
                console.error('Error loading timeline:', error);
                if (timelineSummary) {
                    timelineSummary.textContent = 'Gagal memuat timeline.';
                }
                timelineLoading.classList.add('hidden');
            });
    }

    // Render timeline grid (24 hours)
    function renderTimeline() {
        timelineGrid.innerHTML = '';

        for (let hour = 0; hour < 24; hour++) {
            const hourBlock = document.createElement('div');
            hourBlock.className = 'relative group cursor-pointer';
            hourBlock.title = `${hour.toString().padStart(2, '0')}:00`;

            // Check if there are segments in this hour
            const hourSegments = segments.filter(seg => {
                const segHour = new Date(seg.segment_start_at).getHours();
                return segHour === hour;
            });

            // Check if there are offline events in this hour
            const hourOfflineEvents = events.filter(evt => {
                const evtHour = new Date(evt.event_at).getHours();
                return evtHour === hour && evt.event_type === 'offline';
            });

            // Check if there are other events in this hour
            const hourOtherEvents = events.filter(evt => {
                const evtHour = new Date(evt.event_at).getHours();
                return evtHour === hour && evt.event_type !== 'offline';
            });

            let bgColor = 'bg-gray-300 dark:bg-gray-600'; // No recording
            if (hourSegments.length > 0) {
                bgColor = 'bg-green-500 hover:bg-green-600'; // Has recording
            } else if (hourOfflineEvents.length > 0) {
                bgColor = 'bg-red-500 hover:bg-red-600'; // Offline
            }

            if (hourOtherEvents.length > 0) {
                bgColor += ' border-2 border-yellow-400'; // Has events
            }

            const isSelected = selectedHour === hour;
            const selectedClass = isSelected ? 'ring-2 ring-offset-2 ring-blue-500 dark:ring-blue-400 dark:ring-offset-gray-900' : '';
            hourBlock.className += ` ${bgColor} ${selectedClass} rounded h-full flex items-center justify-center text-[10px] text-white font-semibold transition`;
            hourBlock.textContent = hour.toString().padStart(2, '0');

            hourBlock.addEventListener('click', () => {
                if (hourSegments.length > 0) {
                    selectedHour = hour;
                    renderTimeline();
                    playSegment(hourSegments[0]);
                } else {
                    selectedHour = hour;
                    renderTimeline();
                    clearSegmentInfo('Tidak ada segmen rekaman pada jam ini.');
                }
            });

            timelineGrid.appendChild(hourBlock);
        }
    }

    function renderHourLabels() {
        if (!timelineHourLabels) return;

        timelineHourLabels.innerHTML = '';
        for (let hour = 0; hour < 24; hour++) {
            const label = document.createElement('div');
            label.className = 'text-center';
            label.textContent = hour.toString().padStart(2, '0');
            timelineHourLabels.appendChild(label);
        }
    }

    function updateTimelineSummary() {
        if (!timelineSummary) return;

        const availableHours = new Set(
            segments.map(seg => new Date(seg.segment_start_at).getHours())
        ).size;
        const eventCount = events.length;

        timelineSummary.textContent = `${segments.length} segmen, ${availableHours} jam tersedia, ${eventCount} event`;
    }

    function clearSegmentInfo(message = 'Pilih blok jam berwarna hijau pada timeline untuk melihat detail segmen.') {
        if (segmentEmptyHint) {
            segmentEmptyHint.textContent = message;
            segmentEmptyHint.classList.remove('hidden');
        }

        if (segmentStateBadge) {
            segmentStateBadge.textContent = 'Belum dipilih';
            segmentStateBadge.className = 'inline-flex items-center px-2 py-1 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';
        }

        if (segmentStart) segmentStart.textContent = '-';
        if (segmentEnd) segmentEnd.textContent = '-';
        if (segmentDuration) segmentDuration.textContent = '-';
        if (segmentSize) segmentSize.textContent = '-';
        if (segmentMode) segmentMode.textContent = '-';
        if (segmentCodec) segmentCodec.textContent = '-';
        if (segmentResolution) segmentResolution.textContent = '-';
        if (segmentIntegrity) segmentIntegrity.textContent = '-';
    }

    // Play selected segment
    function playSegment(segment) {
        // In real implementation, you would fetch the actual video file
        // For now, we'll just show segment info
        
        playerPlaceholder.classList.add('hidden');
        playbackVideo.classList.remove('hidden');

        if (segmentEmptyHint) {
            segmentEmptyHint.classList.add('hidden');
        }
        if (segmentStateBadge) {
            segmentStateBadge.textContent = 'Segmen dipilih';
            segmentStateBadge.className = 'inline-flex items-center px-2 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300';
        }

        // Update segment info
        const startTime = new Date(segment.segment_start_at);
        const endTime = new Date(segment.segment_end_at);
        
        if (segmentStart) segmentStart.textContent = startTime.toLocaleTimeString('id-ID');
        if (segmentEnd) segmentEnd.textContent = endTime.toLocaleTimeString('id-ID');
        if (segmentDuration) segmentDuration.textContent = formatDuration(segment.duration_seconds);
        if (segmentSize) segmentSize.textContent = formatFileSize(segment.file_size_bytes);
        if (segmentMode) segmentMode.textContent = segment.record_mode || '-';
        if (segmentCodec) segmentCodec.textContent = segment.codec || '-';
        if (segmentResolution) segmentResolution.textContent = segment.resolution || '-';
        if (segmentIntegrity) segmentIntegrity.textContent = segment.integrity_status || '-';

        if (segment.playback_url) {
            playbackVideo.src = segment.playback_url;
            playbackVideo.load();
            playbackVideo.play().catch(() => {
                // Browser autoplay policy may block playback before user interaction.
            });
        }
    }

    // Format duration in seconds to readable format
    function formatDuration(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${minutes}m ${secs}s`;
    }

    // Format file size to readable format
    function formatFileSize(bytes) {
        if (!bytes) return '-';
        const mb = bytes / (1024 * 1024);
        if (mb < 1) {
            return (bytes / 1024).toFixed(2) + ' KB';
        }
        return mb.toFixed(2) + ' MB';
    }

    // Initialize
    clearSegmentInfo();
    renderHourLabels();
    loadTimeline();
});

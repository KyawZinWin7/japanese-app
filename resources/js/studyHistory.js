const pendingEntries = new Map();
let flushTimer = null;
let lifecycleBound = false;
const csrfToken = typeof document !== 'undefined'
    ? document.head.querySelector('meta[name="csrf-token"]')?.content ?? null
    : null;

function queueEntry(entry, resume) {
    bindLifecycleFlush();

    pendingEntries.set(entry.id, {
        _token: csrfToken,
        entryKey: entry.id,
        href: entry.href,
        title: entry.title,
        subtitle: entry.subtitle ?? null,
        progressLabel: entry.progressLabel ?? null,
        state: entry.state ?? {},
        resume,
    });

    if (flushTimer !== null) {
        window.clearTimeout(flushTimer);
    }

    flushTimer = window.setTimeout(flushEntries, 250);
}

async function flushEntries() {
    const entries = Array.from(pendingEntries.values());

    pendingEntries.clear();
    flushTimer = null;

    await Promise.all(entries.map((entry) => window.axios.post('/study-history/sync', entry).catch(() => null)));
}

function flushEntriesOnExit() {
    if (pendingEntries.size === 0) {
        return;
    }

    const entries = Array.from(pendingEntries.values());

    pendingEntries.clear();

    if (flushTimer !== null) {
        window.clearTimeout(flushTimer);
        flushTimer = null;
    }

    if (!navigator.sendBeacon) {
        return;
    }

    entries.forEach((entry) => {
        const payload = new Blob([JSON.stringify(entry)], {
            type: 'application/json',
        });

        navigator.sendBeacon('/study-history/sync', payload);
    });
}

function bindLifecycleFlush() {
    if (lifecycleBound || typeof window === 'undefined') {
        return;
    }

    lifecycleBound = true;
    window.addEventListener('pagehide', flushEntriesOnExit);
}

export function trackStudyHistory(entry) {
    queueEntry(entry, false);
}

export function saveStudyResume(entry) {
    queueEntry(entry, true);
}

export function clearStudyResume(entry) {
    queueEntry(entry, false);
}

export function reorderCardsBySavedOrder(cards, savedOrderIds) {
    if (!Array.isArray(savedOrderIds) || savedOrderIds.length === 0) {
        return [...cards];
    }

    const cardsById = new Map(cards.map((card) => [String(card.id), card]));
    const orderedCards = [];
    const seenIds = new Set();

    savedOrderIds.forEach((id) => {
        const normalizedId = String(id);
        const card = cardsById.get(normalizedId);

        if (!card || seenIds.has(normalizedId)) {
            return;
        }

        orderedCards.push(card);
        seenIds.add(normalizedId);
    });

    cards.forEach((card) => {
        const normalizedId = String(card.id);

        if (!seenIds.has(normalizedId)) {
            orderedCards.push(card);
        }
    });

    return orderedCards;
}

export function resolveSavedActiveIndex(cards, studyState) {
    const savedActiveCardId = studyState?.activeCardId;

    if (savedActiveCardId !== undefined && savedActiveCardId !== null) {
        const savedIndex = cards.findIndex((card) => String(card.id) === String(savedActiveCardId));

        if (savedIndex >= 0) {
            return savedIndex;
        }
    }

    const savedIndex = Number(studyState?.activeIndex ?? 0);

    if (Number.isInteger(savedIndex) && savedIndex >= 0 && savedIndex < cards.length) {
        return savedIndex;
    }

    return 0;
}

export function buildFlashcardStudyState(cards, originalCards, activeIndex, showBack) {
    return {
        activeIndex,
        activeCardId: cards[activeIndex]?.id ?? null,
        showBack,
        isShuffled: hasCustomCardOrder(cards, originalCards),
        cardOrderIds: cards.map((card) => card.id),
    };
}

function hasCustomCardOrder(cards, originalCards) {
    if (!Array.isArray(originalCards) || cards.length !== originalCards.length) {
        return false;
    }

    return cards.some((card, index) => String(card.id) !== String(originalCards[index]?.id));
}

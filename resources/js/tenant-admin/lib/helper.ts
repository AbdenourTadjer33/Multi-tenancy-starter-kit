function capitalize(word: string) {
    if (word.length === 0) return word;
    return word.charAt(0).toUpperCase() + word.slice(1);
}

function getInitials(name: string) {
    return name
        .split(" ")
        .map((word) => word[0])
        .slice(0, 3)
        .join("")
        .toUpperCase();
}

export { getInitials };

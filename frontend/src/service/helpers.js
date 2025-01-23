export const getFillPercentage = (limit, spendings) => {
    const absoluteLimit = Math.abs(limit);
    const absoluteSpendings = Math.abs(spendings);

    if (absoluteLimit === 0) {
        throw new Error('Limit cannot be zero.');
    }

    const percentage = Math.min((absoluteSpendings / absoluteLimit) * 100, 100);

    return `${percentage.toFixed(2)}%`;
};


export const formatPrice = (amount) => {
    if (parseInt(amount) > 0) {
        return `+$${amount}`
    }

    return `-$${Math.abs(amount)}`;
}

export const getRemainingAmount = (limit, spendings) => {
    const absoluteLimit = Math.abs(limit);
    const absoluteSpendings = Math.abs(spendings);

    if (absoluteLimit === 0) {
        throw new Error('Limit cannot be zero.');
    }

    if (absoluteSpendings > absoluteLimit) {
        return '$0';
    }

    const remainingAmount = absoluteLimit - absoluteSpendings;
    return `${remainingAmount.toFixed(2)}`;
}

export const hexToRgb = (hex, opacity) => {
    const test = hex.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i
        , (m, r, g, b) => '#' + r + r + g + g + b + b)
        .substring(1).match(/.{2}/g)
        .map(x => parseInt(x, 16))

    return `rgb(${test},${opacity})`
}

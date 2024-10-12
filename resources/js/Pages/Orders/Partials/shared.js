export const orderStatus = {
    new: {
        label: "New",
        icon: "clock-fill",
        color: "neutral",
    },
    shipped: {
        label: "Shipped",
        icon: "play-circle-fill",
        color: "info",
    },
    received: {
        label: "Received",
        icon: "check-circle-fill",
        color: "success",
    },
    cancelled: {
        label: "Cancelled",
        icon: "x-circle-fill",
        color: "error",
    },
};

export const statusOptions = Object.keys(orderStatus);

export const orderStatus = {
    new: {
        label: "New",
        theme: "secondary",
    },
    shipped: {
        label: "Shipped",
        theme: "primary",
    },
    received: {
        label: "Received",
        theme: "success",
    },
    cancelled: {
        label: "Cancelled",
        theme: "danger",
    },
};

export const statusOptions = Object.keys(orderStatus);
// TODO: convert this file to typescript

import { isPastDate } from "@/Shared/utils";

export const invoiceStatus = {
    pending: {
        label: "Pending",
        icon: "clock-fill",
        color: "neutral",
    },
    paid: {
        label: "Paid",
        icon: "check-circle-fill",
        color: "success",
    },
    overdue: {
        label: "Overdue",
        icon: "exclamation-circle-fill",
        color: "error",
    },
};

export const statusOptions = Object.keys(invoiceStatus);

export const makeStatus = (invoice) => {
    if (invoice.balance >= 0) {
        return "paid";
    }

    return isPastDate(invoice.due_date) ? "overdue" : "pending";
};

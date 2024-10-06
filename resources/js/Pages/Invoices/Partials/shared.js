import { isPastDate } from "@/Shared/utils";

export const invoiceStatus = {
    pending: {
        label: "Pending",
        theme: "secondary",
    },
    paid: {
        label: "Paid",
        theme: "success",
    },
    overdue: {
        label: "Overdue",
        theme: "danger",
    },
};

export const statusOptions = Object.keys(invoiceStatus);

export const makeStatus = (invoice) => {
    if (invoice.balance >= 0) {
        return "paid";
    }

    return isPastDate(invoice.due_date) ? "overdue" : "pending";
};

const userRoles = {
    expert: "person-workspace",
    admin: "person-video2",
};

const deviceTypes = {
    phone: "phone",
    tablet: "tablet",
    laptop: "laptop",
    desktop: "display",
    other: "hdd",
};

const transactionTypes = {
    payment: "plus-lg",    
    discount: "percent",
    claim: "shield-check",
    refund: "dash-lg",
};

const transactionMethods = {
    cash: "cash",
    card: "credit-card",
    online: "globe",
};

const actions = {
    // CRUD
    view: "eye",
    edit: "pencil",
    create: "plus-lg",
    delete: "trash",

    // QUERY
    search: "search",
    filter: "filter",
    sort: "sort-down",
    next: "chevron-right",
    previous: "chevron-left",

    // OTHER
    print: "printer",
    lock: "lock",
    unlock: "unlock",
    login: "box-arrow-in-left",
    logout: "box-arrow-in-right",
    upload: "upload",
    resolve: "wrench",
    return: "reply",
    sign: "pen",
    dismiss: "x-lg",
    toggle: "three-dots-vertical",
};

const fields = {
    // COMMON
    id: "hash",
    time: "clock",
    date: "calendar-date",
    note: "sticky",

    // CONTACT
    company: "building",
    phone: "phone",
    email: "envelope",
    address: "geo-alt",

    // SIGNS
    info: "info-circle",
    warning: "exclamation-triangle",
    error: "x-octagon",

    // OTHER
    role: "key",
    serial_number: "upc",
    money: "cash-stack",
    attachment: "paperclip",
    file: "file-earmark",
    chart: "graph-up-arrow",
};

export default {
    dashboard: "speedometer2",
    customer: "people",

    user: "person-workspace",
    ...userRoles,

    device: "hdd",
    ...deviceTypes,

    task: "clipboard",
    order: "bag",

    invoice: "receipt",
    transaction: "credit-card",
    ...transactionTypes,
    ...transactionMethods,

    profile: "person",
    setting: "gear",

    ...actions,
    ...fields,
};

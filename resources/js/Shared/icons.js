const userRoles = {
    expert: "person-workspace",
    admin: "person-video2",
};

const assetTypes = {
    desktop: "display",
    laptop: "laptop",
    tablet: "tablet",
    phone: "phone",
    console: "controller",
    printer: "printer",
    navigator: "compass",
    peripheral: "keyboard",
    other: "hdd",
};

const paymentMethods = {
    cash: "cash",
    card: "credit-card",
    online: "globe",
};

const actions = {
    // CRUD
    view: "eye",
    edit: "pencil",
    remove: "trash",
    create: "plus-circle",

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
    notes: "sticky",

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
    serial: "upc",
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

    asset: "hdd",
    ...assetTypes,

    task: "clipboard",

    payment: "credit-card",
    ...paymentMethods,

    profile: "person",
    setting: "gear",

    ...actions,
    ...fields,
};

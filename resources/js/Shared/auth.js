import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

export const auth = computed(() => usePage().props.auth);

export const user = computed(() => auth.value.user);

export const isAdmin = computed(() => auth.value.user.role === "admin");

export const isMe = (otherUser) => user.value.id === otherUser?.id;

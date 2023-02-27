<script setup>
import { Head, Link } from "@inertiajs/vue3";
import StatCard from "@/Components/StatCard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Card from "@/Components/Card.vue";
import StackedList from "@/Components/StackedList.vue";
import StackedListItem from "@/Components/StackedListItem.vue";

const assets = [
    {
        id: 72,
        customer_id: 50,
        user_id: 8,
        name: "Galaxy Tab",
        brand: "Samsung",
        type: "tablet",
        serial: "9e7332fc-afa5-33be-b482-326f5ca23e2d",
        purchase_date: null,
        warranty: 12,
        problem:
            "Quibusdam debitis eos rerum. Aut qui incidunt sapiente vel. Pariatur provident minus sit numquam.",
        notes: null,
        status: "in_progress",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: "2006-07-24 08:21:04",
        tasks_count: 2,
        total_cost: "52.99",
        customer: {
            id: 50,
            name: "Webster Kub",
        },
    },
    {
        id: 71,
        customer_id: 49,
        user_id: 8,
        name: "iPad",
        brand: "Apple",
        type: "tablet",
        serial: "ab726088-5903-327e-afe2-7762c4f4f6c4",
        purchase_date: null,
        warranty: 5,
        problem:
            "Nihil neque alias harum ipsum. Odit voluptatem ea et illo sed. Enim velit officiis et id.",
        notes: "Id perferendis velit qui et sapiente corrupti quo et. Nam aut ea et incidunt at nihil. Quos quos veniam corrupti quaerat voluptas iste pariatur assumenda.",
        status: "returned",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: "2011-08-29 00:43:55",
        tasks_count: 3,
        total_cost: "94.41",
        customer: {
            id: 49,
            name: "Prof. Diamond Donnelly III",
        },
    },
    {
        id: 70,
        customer_id: 49,
        user_id: 9,
        name: "Thinkpad",
        brand: "Lenovo",
        type: "laptop",
        serial: "8e88c4ee-19d4-3fcc-8ef5-16acc115aae2",
        purchase_date: null,
        warranty: 9,
        problem:
            "Nihil autem ea aut suscipit. Consequatur rem distinctio recusandae qui. Maiores quos voluptas incidunt voluptatum deleniti.",
        notes: null,
        status: "ready",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: "1979-04-29 20:59:26",
        tasks_count: 3,
        total_cost: "244.57",
        customer: {
            id: 49,
            name: "Prof. Diamond Donnelly III",
        },
    },
    {
        id: 69,
        customer_id: 48,
        user_id: 5,
        name: "Galaxy Tab",
        brand: "Samsung",
        type: "tablet",
        serial: "8f1c5a2c-8b02-3cb2-b3d4-031e42aacb74",
        purchase_date: null,
        warranty: 7,
        problem:
            "Consectetur atque et molestias rerum doloremque numquam veniam assumenda. Perferendis vitae laboriosam est. Sapiente laudantium provident quis nemo voluptatem ab. Aut id vero est et beatae porro.",
        notes: null,
        status: "returned",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: null,
        tasks_count: 1,
        total_cost: "24.18",
        customer: {
            id: 48,
            name: "Destiney Schmidt",
        },
    },
    {
        id: 68,
        customer_id: 48,
        user_id: 2,
        name: "Thinkpad",
        brand: "Lenovo",
        type: "laptop",
        serial: "04d6c1ee-8199-317f-a7b6-d23e55eb466b",
        purchase_date: null,
        warranty: 1,
        problem:
            "Itaque excepturi aspernatur doloremque qui ea. Aut qui corporis laborum molestiae in asperiores.",
        notes: null,
        status: "ready",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: "1975-07-05 22:34:44",
        tasks_count: 3,
        total_cost: "178.44",
        customer: {
            id: 48,
            name: "Destiney Schmidt",
        },
    },
    {
        id: 67,
        customer_id: 47,
        user_id: 8,
        name: "Galaxy Tab",
        brand: "Samsung",
        type: "tablet",
        serial: "ebd423fa-43c2-3ede-8e3c-b8a838739520",
        purchase_date: null,
        warranty: 3,
        problem:
            "Facere eveniet consequatur asperiores eum ad quos eum. Quia itaque maiores et enim. Aspernatur est eum omnis quasi vel sed eos nam. Eveniet reiciendis quae omnis eius atque.",
        notes: null,
        status: "ready",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: "1983-10-03 22:20:13",
        tasks_count: 1,
        total_cost: "58.76",
        customer: {
            id: 47,
            name: "Dr. Freida Johnston",
        },
    },
    {
        id: 66,
        customer_id: 46,
        user_id: 5,
        name: "Go Comfort",
        brand: "TomTom",
        type: "navigator",
        serial: "4ff780ae-e5f0-3c2c-a8f3-9ee3a68f97d8",
        purchase_date: "1973-01-29",
        warranty: 10,
        problem:
            "Eum voluptatem et nostrum minima. Id sit molestias consequatur omnis optio consequatur velit ea. Minus voluptatem aut ipsum. Fugiat sint nemo ad voluptas vel expedita quaerat vel.",
        notes: "Et et soluta esse inventore non. Voluptatum velit nulla numquam explicabo inventore. Eum tempora facilis est accusantium incidunt cumque fuga.",
        status: "returned",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: "1972-06-25 05:38:47",
        tasks_count: 2,
        total_cost: "58.62",
        customer: {
            id: 46,
            name: "Prof. Joe Gerlach",
        },
    },
    {
        id: 65,
        customer_id: 46,
        user_id: 9,
        name: "Thinkpad",
        brand: "Lenovo",
        type: "laptop",
        serial: "c6d9a99c-016b-30eb-bc83-2aeb10429b73",
        purchase_date: "1999-11-05",
        warranty: 1,
        problem:
            "Vel repellat veritatis nisi ducimus. Et suscipit dolorem asperiores aliquid accusantium alias suscipit. Qui suscipit excepturi repudiandae labore deserunt et porro.",
        notes: "Beatae repellendus vitae consequatur iste ea voluptate. Distinctio assumenda nesciunt qui sapiente eum cumque voluptatibus quas. Voluptas sint dolorem quo tenetur voluptatem.",
        status: "returned",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: null,
        tasks_count: 1,
        total_cost: "16.39",
        customer: {
            id: 46,
            name: "Prof. Joe Gerlach",
        },
    },
    {
        id: 64,
        customer_id: 45,
        user_id: 8,
        name: "Deskjet",
        brand: "Hp",
        type: "printer",
        serial: "9a38310a-0264-3d2f-b2e0-86ed0d6f7817",
        purchase_date: null,
        warranty: 7,
        problem:
            "Quo facilis fuga iure sint sit et pariatur. Et est odio excepturi aut eum rem voluptatem. Aliquid nisi vel quia rerum temporibus eaque ut. Corrupti dolores sed optio ut minus occaecati.",
        notes: "Exercitationem quidem fugit et illo neque saepe. Illum eum vel quidem sed iste nulla.",
        status: "ready",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: "2007-08-12 15:50:40",
        tasks_count: 2,
        total_cost: "138.50",
        customer: {
            id: 45,
            name: "Colin Waters",
        },
    },
    {
        id: 63,
        customer_id: 45,
        user_id: 1,
        name: "Deskjet",
        brand: "Hp",
        type: "printer",
        serial: "26eb9465-b760-3b05-9319-609ced80ce35",
        purchase_date: "1981-09-25",
        warranty: 11,
        problem:
            "Ipsam et eos voluptatibus amet labore voluptatum. Voluptatem iure voluptas rem ex assumenda labore. Est velit blanditiis quia. Sint repellendus qui hic sint esse fugiat commodi. Sed illo nulla optio.",
        notes: null,
        status: "returned",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: null,
        tasks_count: 2,
        total_cost: "128.47",
        customer: {
            id: 45,
            name: "Colin Waters",
        },
    },
    {
        id: 62,
        customer_id: 44,
        user_id: 4,
        name: "Playstation",
        brand: "Sony",
        type: "console",
        serial: "2f7b7478-9bc3-31d7-8719-ed110a44a82c",
        purchase_date: null,
        warranty: 12,
        problem: "Quos ab id perspiciatis rerum et. Quod voluptatem id quia.",
        notes: null,
        status: "in_progress",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: "1984-04-11 16:02:48",
        tasks_count: 2,
        total_cost: "183.78",
        customer: {
            id: 44,
            name: "Vivien Grady V",
        },
    },
    {
        id: 61,
        customer_id: 43,
        user_id: 3,
        name: "Deskjet",
        brand: "Hp",
        type: "printer",
        serial: "86f79343-db4c-3378-ac07-b8bc1c4b2eed",
        purchase_date: null,
        warranty: 7,
        problem:
            "Quos et magnam eos inventore et. Voluptas animi quod dolorem. Tempora qui blanditiis consequuntur quo. Optio similique enim quibusdam aut.",
        notes: null,
        status: "ready",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: null,
        tasks_count: 3,
        total_cost: "180.73",
        customer: {
            id: 43,
            name: "Laisha Batz",
        },
    },
    {
        id: 60,
        customer_id: 42,
        user_id: 7,
        name: "Galaxy Tab",
        brand: "Samsung",
        type: "tablet",
        serial: "98173efe-7f4d-318e-9c8f-ccab5e72b7b0",
        purchase_date: null,
        warranty: 9,
        problem:
            "Odit aut ad quidem et omnis. Pariatur accusantium vel voluptatibus eos impedit a id eum. Id sapiente consequuntur commodi ratione est.",
        notes: null,
        status: "in_progress",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: null,
        tasks_count: 3,
        total_cost: "51.60",
        customer: {
            id: 42,
            name: "Verdie Lowe",
        },
    },
    {
        id: 59,
        customer_id: 42,
        user_id: 1,
        name: "Thinkpad",
        brand: "Lenovo",
        type: "laptop",
        serial: "f5eedc74-7b2e-3f15-9de8-74f0a125ea49",
        purchase_date: null,
        warranty: 5,
        problem:
            "Consequatur ut magnam tempore. Occaecati laudantium eos impedit maiores. Ut ea maiores consequatur placeat.",
        notes: null,
        status: "ready",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: "2015-02-22 06:48:25",
        tasks_count: 2,
        total_cost: "41.44",
        customer: {
            id: 42,
            name: "Verdie Lowe",
        },
    },
    {
        id: 58,
        customer_id: 41,
        user_id: 11,
        name: "Go Comfort",
        brand: "TomTom",
        type: "navigator",
        serial: "d8829bf5-918c-37c4-a922-b6297e16065d",
        purchase_date: null,
        warranty: 1,
        problem:
            "Sint fugit occaecati iste ipsa. Dolores in incidunt pariatur ut autem consequatur iusto praesentium. Est rem delectus dicta laboriosam doloribus eligendi dolores.",
        notes: null,
        status: "in_progress",
        created_at: "2023-02-26T11:46:27.000000Z",
        updated_at: "2023-02-26T11:46:27.000000Z",
        returned_at: "2018-05-16 02:38:08",
        tasks_count: 2,
        total_cost: "91.04",
        customer: {
            id: 41,
            name: "Halle Friesen Jr.",
        },
    },
];

// for demo puroses take split assets in 3 groups (in progress, ready, returned)
// and create a variable for each group out of the assets array

const assetsInProgress = assets.filter(
    (asset) => asset.status === "in_progress"
);
const assetsReady = assets.filter((asset) => asset.status === "ready");
const assetsReturned = assets.filter((asset) => asset.status === "returned");
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-8">
                    <StatCard
                        label="Assets"
                        :items="[
                            { label: 'In Progress', value: 8 },
                            { label: 'Ready', value: 2 },
                        ]"
                    />

                    <StatCard
                        label="Tasks"
                        :items="[
                            { label: 'Pending', value: 10 },
                            { label: 'Completed', value: 23 },
                        ]"
                    />

                    <StatCard
                        label="Earnings"
                        :items="[
                            { label: 'Labor Cost', value: '120€' },
                            { label: 'Due Pay', value: '300€' },
                        ]"
                    />
                </div>

                <div class="container flex flex-col sm:flex-row gap-5">
                    <Card class="flex-1" label="Latest assets in progress">
                        <StackedList class="-mx-4">
                            <StackedListItem
                                v-for="asset in assetsInProgress"
                                :key="asset.id"
                                :href="route('assets.show', asset.id)"
                            >
                                <span class="w-2/3">
                                    {{ asset.brand }} {{ asset.name }}
                                    <br />
                                    <span class="text-sm text-gray-400">
                                        {{ asset.customer.name }}
                                    </span>
                                </span>

                                <span
                                    class="px-2.5 py-0.5 rounded-full bg-gray-200 dark:bg-gray-700 text-sm"
                                >
                                    {{ asset.status }}
                                </span>
                            </StackedListItem>
                        </StackedList>

                        <div class="flex justify-end mt-4 px-1">
                            <Link
                                class=" text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-200 hover:text-indigo-800"
                                :href="route('assets.index', { status: 'in_progress' })"
                            >
                                View all
                            </Link>
                        </div>
                    </Card>

                    <Card class="flex-1" label="Latest assets ready to pick up">
                        <StackedList class="-mx-4">
                            <StackedListItem
                                v-for="asset in assetsReady"
                                :key="asset.id"
                                :href="route('assets.show', asset.id)"
                            >
                                <span class="w-2/3">
                                    {{ asset.brand }} {{ asset.name }}
                                    <br />
                                    <span class="text-sm text-gray-400">
                                        {{ asset.customer.name }}
                                    </span>
                                </span>

                                <span
                                    class="px-2.5 py-0.5 rounded-full bg-gray-200 dark:bg-gray-700 text-sm"
                                >
                                    {{ asset.status }}
                                </span>
                            </StackedListItem>
                        </StackedList>

                        <div class="flex justify-end mt-4 px-1">
                            <Link
                                class=" text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-200 hover:text-indigo-800"
                                :href="route('assets.index', { status: 'ready' })"
                            >
                                View all
                            </Link>
                        </div>

                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

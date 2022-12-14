<script setup>
defineProps({
    headers: Array,
    data: Array,
});
</script>

<template>
    <div class="overflow-x-auto relative">
        <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="py-3 px-6" v-for="header in headers">
                        {{ header.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    v-if="data.length === 0"
                >
                    <td
                        :colspan="headers.length"
                        class="p-4 text-center text-xl"
                    >
                        No hay información
                    </td>
                </tr>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    v-for="(item, index) in data"
                    :key="index"
                >
                    <td
                        v-for="header in headers"
                        scope="row"
                        class="py-4 px-6 font-medium text-gray-900 dark:text-white"
                    >
                        <slot :name="`cell(${header.key})`" :data="item">
                            {{ item[header.key] }}
                        </slot>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

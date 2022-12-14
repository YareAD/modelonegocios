<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Inertia } from "@inertiajs/inertia";
const props = defineProps({
    title: String,
    requerimientos: Array,
});

const emits = defineEmits(["deleteRequerimiento"]);

const editar = (id) => {
    window.location.href = route("edit-requerimiento", {
        requerimiento: id,
    });
};

const eliminar = (id) => {
    Inertia.delete(
        route("eliminar-requerimiento", {
            requerimiento: id,
        }),
        {
            onSuccess: (page) => {
                emits("deleteRequerimiento", id);
            },
        }
    );
};
</script>

<template>
    <div>
        <h1 class="text-2xl mb-2">{{ title }}</h1>
        <ul
            class="text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
        >
            <li
                v-for="{ id, clave, descripcion } in requerimientos"
                class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600 flex justify-between"
            >
                <p class="text-gray-700 text-lg">
                    {{ `${clave} - ${descripcion}` }}
                </p>
                <div class="flex gap-2">
                    <PrimaryButton @click="eliminar(id)"
                        >Eliminar</PrimaryButton
                    >
                    <PrimaryButton @click="editar(id)">Editar</PrimaryButton>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    proyecto: Object,
});

const menu = [
    {
        label: "Requerimientos",
        route: route("requerimientos", { proyecto: props.proyecto.id }),
    },
    {
        label: "Casos de uso",
        route: route("casos-uso", { proyecto: props.proyecto.id }),
    },
    {
        label: "Actores",
        route: route("actores", { proyecto: props.proyecto.id }),
    },
    {
        label: "Artefactos",
        route: route("artefactos", { proyecto: props.proyecto.id }),
    },
    {
        label: "Procesos",
        route: route("procesos", { proyecto: props.proyecto.id }),
    },
];

const obtenerReporte = async () => {
    window.open(
        route("reporte-proyecto", {
            proyecto: props.proyecto.id,
        }),
        "_blank" // <- This is what makes it open in a new window.
    );
};
</script>

<template>
    <Head title="Nuevo proyecto" />
    <AuthenticatedLayout>
        <div class="container mx-auto mt-10">
            <div>
                <span class="font-bold"> Nombre del proyecto: </span>

                <p>
                    {{ proyecto.nombre }}
                </p>
            </div>
            <div class="mt-10">
                <span class="font-bold">Responsable: </span>
                <p>
                    {{ proyecto.responsable }}
                </p>
            </div>
            <div class="flex my-10 gap-2">
                <PrimaryButton @click="obtenerReporte"
                    >Generar reporte</PrimaryButton
                >
            </div>
            <div class="mt-10">
                <ul
                    class="w-48 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
                    <li
                        v-for="item in menu"
                        class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"
                    >
                        <Link :href="item.route">
                            {{ item.label }}
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { reactive, ref } from "vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    actores: Array,
    proyecto: Object,
});

const dataActores = ref([...props.actores]);

const headers = [
    { label: "Opciones", key: "opt" },
    { label: "Clave", key: "clave" },
    { label: "Nombre", key: "nombre" },
    { label: "Descripcion", key: "descripcion" },
    { label: "Caracteristicas", key: "caracteristicas" },
    { label: "Relaciones", key: "relaciones" },
    { label: "Responsabilidad", key: "responsabilidad" },
    { label: "Actividades de entrada", key: "actividades_entrada" },
    { label: "Actividades de salida", key: "actividades_salida" },
];

const nuevoActor = () => {
    window.location.href = route("nuevo-actor", {
        proyecto: props.proyecto.id,
    });
};

const eliminarActor = (id) => {
    const form = useForm();
    form.delete(route("eliminar-actor", { actor: id }), {
        onSuccess: () => {
            dataActores.value = dataActores.value.filter(
                (actor) => actor.id !== id
            );
        },
    });
};

const editarActor = (id) => {
    window.location.href = route("visualizar-actor", { actor: id });
};

const back = () => {
    window.location.href = route("visualizar-proyecto", {
        proyecto: props.proyecto.id,
    });
};
</script>

<template>
    <Head title="Actores" />
    <AuthenticatedLayout>
        <div class="w-full py-5">
            <div class="container mx-auto">
                <div class="py-3 flex gap-2">
                    <PrimaryButton @click="back"> Atras </PrimaryButton>
                    <PrimaryButton @click="nuevoActor">
                        Nuevo actor
                    </PrimaryButton>
                </div>
                <ul
                    v-for="actor in dataActores"
                    class="text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white mb-10"
                >
                    <li
                        v-for="item in headers"
                        class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"
                    >
                        <span class="font-bold"> {{ item.label }}: </span>
                        <p v-if="item.key !== 'opt'">
                            {{ actor[item.key] }}
                        </p>
                        <div v-else class="flex gap-2">
                            <PrimaryButton @click="eliminarActor(actor.id)">
                                Eliminar
                            </PrimaryButton>

                            <PrimaryButton @click="editarActor(actor.id)">
                                Editar
                            </PrimaryButton>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

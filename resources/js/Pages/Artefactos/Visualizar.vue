<script setup>
import { reactive, ref } from "vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Table from "@/Components/Table.vue";

const props = defineProps({
    artefactos: Array,
    proyecto: Object,
});

const dataArtefactos = ref([...props.artefactos]);

console.log(JSON.stringify(dataArtefactos.value));

const headers = [
    { label: "Opciones", key: "opt" },
    { label: "Clave", key: "clave" },
    { label: "Nombre", key: "nombre" },
    { label: "Descripcion", key: "descripcion" },
    { label: "Datos", key: "datos" },
];

const headers_datos = [
    { label: "Atributo", key: "atributo" },
    { label: "Descripción", key: "descripcion" },
    { label: "Tipo", key: "tipo" },
    { label: "Rango", key: "rango" },
    { label: "Excepciones", key: "excepciones" },
];

const nuevoArtefacto = () => {
    window.location.href = route("nuevo-artefacto", {
        proyecto: props.proyecto.id,
    });
};

const eliminarArtefacto = (id) => {
    const form = useForm();
    form.delete(route("eliminar-artefacto", { artefacto: id }), {
        onSuccess: () => {
            dataArtefactos.value = dataArtefactos.value.filter(
                (actor) => actor.id !== id
            );
        },
    });
};

const editarArtefacto = (id) => {
    window.location.href = route("visualizar-artefacto", { artefacto: id });
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
                    <PrimaryButton @click="nuevoArtefacto">
                        Nuevo artefacto
                    </PrimaryButton>
                </div>
                <ul
                    v-for="artefacto in dataArtefactos"
                    class="text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white mb-10"
                >
                    <li
                        v-for="item in headers"
                        class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"
                    >
                        <span class="font-bold"> {{ item.label }}: </span>
                        <p v-if="item.key !== 'opt' && item.key !== 'datos'">
                            {{ artefacto[item.key] }}
                        </p>
                        <div v-else-if="item.key === 'opt'" class="flex gap-2">
                            <PrimaryButton
                                @click="eliminarArtefacto(artefacto.id)"
                            >
                                Eliminar
                            </PrimaryButton>

                            <PrimaryButton
                                @click="editarArtefacto(artefacto.id)"
                            >
                                Editar
                            </PrimaryButton>
                        </div>
                        <div v-else-if="item.key === 'datos'" class="w-full">
                            <Table
                                :headers="headers_datos"
                                :data="artefacto[item.key]"
                            />
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

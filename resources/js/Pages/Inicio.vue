<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Table from "@/Components/Table.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    proyectos: Array,
});

const dataProyectos = ref([...props.proyectos]);

const headers = [
    { label: "Nombre del proyecto", key: "nombre" },
    { label: "Responsable", key: "responsable" },
    { label: "Opciones", key: "opt" },
];

const nuevoProyecto = () => {
    window.location.href = route("nuevo-proyecto");
};

const seleccionarProyecto = (id) => {
    window.location.href = route("visualizar-proyecto", { proyecto: id });
};

const eliminarProyecto = (id) => {
    Inertia.delete(route("eliminar-proyecto", { proyecto: id }), {
        onSuccess: (page) => {
            dataProyectos.value = page.props.proyectos;
        },
    });
};

const editarProyecto = (id) => {
    window.location.href = route("editar-proyecto", { proyecto: id });
};
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="w-full py-5">
            <div class="container mx-auto">
                <div class="py-3">
                    <PrimaryButton @click="nuevoProyecto">
                        Nuevo proyecto
                    </PrimaryButton>
                </div>
                <Table :headers="headers" :data="dataProyectos">
                    <template #cell(opt)="{ data: { id } }">
                        <div class="flex gap-2">
                            <PrimaryButton @click="seleccionarProyecto(id)">
                                Seleccionar
                            </PrimaryButton>
                            <PrimaryButton @click="editarProyecto(id)">
                                Editar
                            </PrimaryButton>
                            <PrimaryButton @click="eliminarProyecto(id)">
                                Eliminar
                            </PrimaryButton>
                        </div>
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

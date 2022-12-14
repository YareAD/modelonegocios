<script setup>
import { ref, watch } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    proyecto: Object,
});

const dataCasosUso = ref([...props.proyecto.casos_uso]);

const headers = [
    { label: "Opciones", key: "opt" },
    { label: "Clave", key: "clave" },
    { label: "Descripcion", key: "descripcion" },
    { label: "Requerimientos", key: "pivot_requerimientos" },
];

const back = () => {
    window.location.href = route("visualizar-proyecto", {
        proyecto: props.proyecto.id,
    });
};

const nuevoCasoUso = () => {
    window.location.href = route("nuevo-caso-uso", {
        proyecto: props.proyecto.id,
    });
};

const eliminarCasodeUso = (id) => {
    Inertia.delete(route("eliminar-caso-uso", { casoUso: id }), {
        onSuccess: (page) => {
            dataCasosUso.value = page.props.proyecto.casos_uso;
        },
    });
};

const editarCasodeUso = (id) => {
    window.location.href = route("edit-caso-uso", {
        casoUso: id,
    });
};
</script>

<template>
    <Head title="Nuevo proyecto" />
    <AuthenticatedLayout>
        <div class="container mx-auto mt-10">
            <div class="py-3 flex gap-2">
                <PrimaryButton @click="back"> Atras </PrimaryButton>
                <PrimaryButton @click="nuevoCasoUso">
                    Nuevo caso de uso
                </PrimaryButton>
            </div>

            <ul
                v-for="caso in dataCasosUso"
                class="text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white mb-10"
            >
                <li
                    v-for="item in headers"
                    class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"
                >
                    <span class="font-bold"> {{ item.label }}: </span>
                    <p
                        v-if="
                            item.key !== 'opt' &&
                            item.key !== 'pivot_requerimientos'
                        "
                    >
                        {{ caso[item.key] }}
                    </p>
                    <div v-else-if="item.key === 'opt'" class="flex gap-2">
                        <PrimaryButton @click="eliminarCasodeUso(caso.id)">
                            Eliminar
                        </PrimaryButton>

                        <PrimaryButton @click="editarCasodeUso(caso.id)">
                            Editar
                        </PrimaryButton>
                    </div>

                    <div
                        v-else-if="item.key === 'pivot_requerimientos'"
                        class="w-full py-4"
                    >
                        <ul>
                            <li
                                v-for="({ requerimiento }, index) in caso[
                                    item.key
                                ]"
                                :key="index"
                                class="py-1"
                            >
                                <p>
                                    <span class="font-bold">
                                        {{ requerimiento.clave }}
                                    </span>
                                    &nbsp; {{ requerimiento.descripcion }}
                                </p>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>

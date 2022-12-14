<script setup>
import { Inertia } from "@inertiajs/inertia";
import { reactive, ref } from "vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    procesos: Array,
    proyecto: Object,
});

const dataProcesos = ref([...props.procesos]);

const headers = [
    { label: "Opciones", key: "opt" },
    { label: "Plantilla", key: "nombre_plantilla" },
    { label: "Imagen", key: "image_uri" },
    { label: "Nombre", key: "nombre" },
    { label: "Descripcion", key: "descripcion" },
    { label: "Entrada", key: "entrada" },
    { label: "Actores", key: "actores" },
];

const nuevoProceso = () => {
    window.location.href = route("nuevo-proceso", {
        proyecto: props.proyecto.id,
    });
};

const eliminarProceso = (id) => {
    Inertia.delete(route("eliminar-proceso", { proceso: id }), {
        onSuccess: (page) => {
            dataProcesos.value = page.props.procesos;
        },
    });
};
const editarProceso = (id) => {
    window.location.href = route("visualizar-proceso", { proceso: id });
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
                    <PrimaryButton @click="nuevoProceso">
                        Nuevo proceso
                    </PrimaryButton>
                </div>
                <ul
                    v-for="proceso in dataProcesos"
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
                                item.key !== 'actores' &&
                                item.key !== 'image_uri'
                            "
                        >
                            {{ proceso[item.key] }}
                        </p>

                        <div v-else-if="item.key === 'image_uri'">
                            <img
                                class="w-[50%]"
                                :src="proceso[item.key]"
                                alt="proceso-image"
                            />
                        </div>

                        <div v-else-if="item.key === 'opt'" class="flex gap-2">
                            <PrimaryButton @click="eliminarProceso(proceso.id)">
                                Eliminar
                            </PrimaryButton>

                            <PrimaryButton @click="editarProceso(proceso.id)">
                                Editar
                            </PrimaryButton>
                        </div>
                        <div v-else>
                            {{
                                proceso[item.key]
                                    .map(({ nombre }) => nombre)
                                    .join(", ")
                            }}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

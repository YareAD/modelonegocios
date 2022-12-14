<script setup>
import { ref, watch } from "vue";
import { v4 as uuidv4 } from "uuid";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";
import NuevoEditarDato from "@/Pages/Artefactos/NuevoEditarDato.vue";

const props = defineProps({
    proyecto: Object,
});

const modalEditarRegistrar = ref({
    modal: false,
    datoEditar: null,
});

const edit = ref(false);

watch(modalEditarRegistrar, (value) => {
    edit.value = !!value.datoEditar;
});

const datos = ref([]);

const headers_datos = [
    { label: "Atributo", key: "atributo" },
    { label: "Descripción", key: "descripcion" },
    { label: "Tipo", key: "tipo" },
    { label: "Rango", key: "rango" },
    { label: "Excepciones", key: "excepciones" },
    { label: "Opciones", key: "opt" },
];

const form = useForm({
    clave: "",
    nombre: "",
    descripcion: "",
    datos: [],
    proyecto: props.proyecto.id,
});

const openModalNuevoDato = () => {
    modalEditarRegistrar.value = {
        modal: true,
        datoEditar: null,
    };
};

const agregarDato = (dato) => {
    datos.value.push({ ...dato, uid: uuidv4() });
    modalEditarRegistrar.value = {
        ...modalEditarRegistrar.value,
        modal: false,
    };
};

const eliminarDato = (uid) => {
    datos.value = datos.value.filter((dato) => dato.uid !== uid);
};

const editarDatoModal = (dato) => {
    modalEditarRegistrar.value = {
        ...modalEditarRegistrar.value,
        modal: true,
        datoEditar: dato,
    };
};

const editarDato = (dato) => {
    datos.value = datos.value.map((datoA) => {
        if (datoA.uid === dato.uid) return dato;
        return datoA;
    });
    modalEditarRegistrar.value = {
        ...modalEditarRegistrar.value,
        modal: false,
        editarDato: null,
    };
};

const submit = () => {
    form.datos = datos.value;
    form.post(route("nuevo-artefacto-post"), {
        onSuccess: (res) => {
            console.log(res);
        },
    });
};
</script>

<template>
    <Head title="Nuevo actor" />
    <AuthenticatedLayout>
        <div class="w-full py-10">
            <div class="container mx-auto">
                <h1 class="text-2xl text-gray-600">Nuevo artefacto</h1>
                <div
                    class="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
                >
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="clave" value="Clave" />
                            <TextInput
                                id="clave"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.clave"
                                required
                                autofocus
                                autocomplete="clave"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.clave"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="nombre" value="Nombre" />
                            <TextInput
                                id="nombre"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.nombre"
                                required
                                autocomplete="nombre"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.nombre"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="descripcion" value="Descripcion" />
                            <TextAreaInput
                                rows="3"
                                id="descripcion"
                                class="mt-1 block w-full"
                                v-model="form.descripcion"
                                required
                                autocomplete="descripcion"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.descripcion"
                            />
                        </div>

                        <div class="w-full mt-10">
                            <div class="flex items-center">
                                <PrimaryButton
                                    type="button"
                                    @click="openModalNuevoDato"
                                >
                                    Nuevo dato
                                </PrimaryButton>
                            </div>
                            <Table :headers="headers_datos" :data="datos">
                                <template #cell(opt)="{ data }">
                                    <div class="flex gap-2">
                                        <PrimaryButton
                                            type="button"
                                            @click="eliminarDato(data.uid)"
                                        >
                                            Eliminar
                                        </PrimaryButton>
                                        <PrimaryButton
                                            type="button"
                                            @click="editarDatoModal(data)"
                                        >
                                            Editar
                                        </PrimaryButton>
                                    </div>
                                </template>
                            </Table>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton
                                type="submit"
                                class="ml-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Registrar
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <Modal
        v-model="modalEditarRegistrar.modal"
        :title="edit ? 'Editar dato' : 'Agregar dato'"
        size="sm"
        :center-modal="true"
        hidden-footer
    >
        <template #content>
            <NuevoEditarDato
                @on-add="agregarDato"
                @on-edit="editarDato"
                :dato-editar="modalEditarRegistrar.datoEditar"
            />
        </template>
    </Modal>
</template>

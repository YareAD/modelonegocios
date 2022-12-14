<script setup>
import { onBeforeMount } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    datoEditar: Object,
});

const edit = !!props.datoEditar;

const emit = defineEmits(["onAdd", "onEdit"]);

const form = useForm({
    id: -1,
    uid: "",
    atributo: "",
    descripcion: "",
    tipo: "",
    rango: "",
    excepciones: "",
});

const submit = () => {
    const { id, uid, atributo, descripcion, tipo, rango, excepciones } = form;
    if (props.datoEditar) {
        emit("onEdit", {
            id,
            uid,
            atributo,
            descripcion,
            tipo,
            rango,
            excepciones,
        });
    } else {
        emit("onAdd", { atributo, descripcion, tipo, rango, excepciones });
    }
};

onBeforeMount(() => {
    if (props.datoEditar) {
        const { id, uid, atributo, descripcion, tipo, rango, excepciones } =
            props.datoEditar;

        form.id = id;
        form.uid = uid;
        form.atributo = atributo;
        form.descripcion = descripcion;
        form.tipo = tipo;
        form.rango = rango;
        form.excepciones = excepciones;
    }
});
</script>
<template>
    <form @submit.prevent="submit">
        <div class="py-3">
            <InputLabel for="atributo" value="Atributo" />
            <TextInput
                id="atributo"
                type="text"
                class="mt-1 block w-full"
                v-model="form.atributo"
                required
                autofocus
                autocomplete="atributo"
            />
            <InputError class="mt-2" :message="form.errors.atributo" />
        </div>

        <div class="py-3">
            <InputLabel for="descripcion" value="Descripcion" />
            <TextAreaInput
                rows="3"
                id="descripcion"
                class="mt-1 block w-full"
                v-model="form.descripcion"
                required
                autocomplete="descripcion"
            />
            <InputError class="mt-2" :message="form.errors.atributo" />
        </div>

        <div class="py-3">
            <InputLabel for="tipo" value="Tipo" />
            <TextInput
                id="tipo"
                type="text"
                class="mt-1 block w-full"
                v-model="form.tipo"
                required
                autocomplete="tipo"
            />
            <InputError class="mt-2" :message="form.errors.tipo" />
        </div>

        <div class="py-3">
            <InputLabel for="rango" value="Rango" />
            <TextInput
                id="rango"
                type="text"
                class="mt-1 block w-full"
                v-model="form.rango"
                required
                autocomplete="rango"
            />
            <InputError class="mt-2" :message="form.errors.rango" />
        </div>
        <div class="py-3">
            <InputLabel for="excepciones" value="Excepciones" />
            <TextAreaInput
                rows="3"
                id="excepciones"
                class="mt-1 block w-full"
                v-model="form.excepciones"
                required
                autocomplete="excepciones"
            />
            <InputError class="mt-2" :message="form.errors.excepciones" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <PrimaryButton
                type="submit"
                class="ml-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                {{ edit ? "Editar" : "Agregar" }}
            </PrimaryButton>
        </div>
    </form>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';

import { Equipamento } from '../../models/Equipamento';
import AlertDialog from '../components/AlertDialog.vue';
import CreateDialog from '../components/CreateDialog.vue';
import EquipmentTable from '../components/EquipmentTable.vue';

const equipments = ref<Equipamento[]>([]);
const equipmentSelected = ref<Equipamento>();
const isAlertDialogOpen = ref<boolean>(false);
const isCreateDialogOpen = ref<boolean>(false);

const close = (update: boolean | null = false) => {
    if (update) {
        fetchEquipments();
    }
    isAlertDialogOpen.value = false;
    isCreateDialogOpen.value = false;
};

const openAlertDialog = (equipment: Equipamento) => {
    equipmentSelected.value = equipment;
    isAlertDialogOpen.value = true;
};

const openCreateDialog = () => {
    isCreateDialogOpen.value = true;
};

async function fetchEquipments() {
    try {
        const response = await axios.get('/equipamentos');
        equipments.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar equipamentos:', error);
    }
};

async function update() {
    try {
        await axios.get('/sensores/update')
            .then(() => { fetchEquipments(); })
            .catch(error => console.error(error));
    } catch (error) {
        console.error('Erro ao atualizar sensores:', error);
    }
}

function turnOn(equipment: Equipamento) {
    axios.post(`/equipamentos/${equipment.id}/turnOn`)
        .then(() => { fetchEquipments(); })
        .catch(error => console.error(error));
}

function turnOff(equipment: Equipamento) {
    axios.post(`/equipamentos/${equipment.id}/turnOff`)
        .then(() => { fetchEquipments(); })
        .catch(error => console.error(error));
}

function toggleStatus(equipment: Equipamento) {
    if (equipment.status) {
        turnOff(equipment);
    } else {
        turnOn(equipment);
    }
}

onMounted(() => {
    fetchEquipments();
    setInterval(update, 10000);
});
</script>

<template>
    <div class="background">
        <div class="content">
            <section class="area-section">
                <h1>Gerenciador de Equipamentos</h1>
                <button @click="openCreateDialog">
                    <span class="material-symbols-outlined">add</span>
                    <p> Adicionar equipamento</p>
                </button>
            </section>
            <section class="body-section">
                <EquipmentTable :equipments="equipments" @openAlertDialog="openAlertDialog($event)"
                    @toggleStatus="toggleStatus"></EquipmentTable>
            </section>
        </div>
    </div>
    <AlertDialog :isOpen="isAlertDialogOpen" :equipment="equipmentSelected" @close="close"></AlertDialog>
    <CreateDialog :isOpen="isCreateDialogOpen" @close="close"></CreateDialog>
</template>

<style scoped>
h1,
p {
    font-family: Montserrat;
    margin: 0;
}

h1 {
    color: #024C35;
    font-size: 32px;
    font-weight: 600;
}

p {
    font-size: 16px;
    font-weight: 500;
}

button {
    background-color: white;
    border: 2px solid #F6741C;
    border-radius: 12px;
    color: #F6741C;
    cursor: pointer;
    text-align: center;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin: 0;
    padding: 8px;
}

button:hover {
    background-color: #F6741C;
    color: white;
}

button:active {
    background-color: #D35614;
    border: 2px solid #D35614;
    color: white;
}

.area-section {
    background-color: white;
    border: 1px solid #B0B8B3;
    border-radius: 24px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding-block: 20px;
    padding-inline: 24px;
}

.body-section {
    background-color: white;
    border: 1px solid #B0B8B3;
    border-radius: 24px;
    padding-block: 20px;
    padding-inline: 24px;
    height: 100%;
}

.background {
    background-color: #F0F5F2;
    display: flex;
    flex-direction: column;
    align-items: start;
    justify-content: end;
    height: 100vh;
}

.content {
    display: flex;
    flex-direction: column;
    gap: 24px;
    padding: 32px;
    height: 100%;
    width: 100%;
    box-sizing: border-box;
}
</style>
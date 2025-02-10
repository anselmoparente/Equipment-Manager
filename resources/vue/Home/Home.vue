<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';

import { Equipamento } from '../../models/Equipamento';

const equipments = ref<Equipamento[]>([]);

const atualizarSensores = async () => {
    try {
        // Chama a API para atualizar os sensores
        await axios.post('/api/sensor/atualizar');
        console.log('Sensores atualizados!');
        // Após a atualização, busca os equipamentos e sensores para exibição
        fetchEquipments();
    } catch (error) {
        console.error('Erro ao atualizar sensores:', error);
    }
};


const fetchEquipments = async () => {
    try {
        const response = await axios.get('/api/equipamentos');
        equipments.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar equipamentos:', error);
    }
};

function toggle(equipment: Equipamento) {
    const newStatus = equipment.status == true ? false : true;
    axios.post(`/api/equipments/${equipment.id}/toggle`, { status: newStatus })
        .then(() => {
            this.fetchEquipments();
        })
        .catch(error => console.error(error));
}

onMounted(() => {
    fetchEquipments();
    // Atualiza os sensores a cada 5 segundos
    setInterval(atualizarSensores, 5000);
});
</script>

<template>
    <div class="background">
        <div class="content">
            <section class="area-section">
                <p>Área dos Dispositivos</p>
            </section>
        </div>
        <div>
            <h2>Equipamentos</h2>
            <ul>
                <li v-for="equipment in equipments" :key="equipment.id">
                    <strong>{{ equipment.nome }}</strong> - Status: {{ equipment.status }}
                    <button @click="toggle(equipment)">{{ equipment.status == true ? 'Desligar' : 'Ligar' }}</button>

                    <!-- Lista de alarmes para o equipamento -->
                    <!-- <ul v-if="equipment. && equip.alarms.length">
                        <li v-for="alarm in equip.alarms" :key="alarm.id">
                            Alarme: {{ alarm.value }} em {{ alarm.created_at }}
                        </li>
                    </ul> -->
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
p {
    color: #032826;
    font-family: Montserrat;
    font-size: 32px;
    font-weight: 600;
    margin: 0;
}

.area-section {
    background-color: white;
    border: 1px solid #B0B8B3;
    border-radius: 24px;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 16px;
    padding-block: 20px;
    padding-inline: 24px;
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
    padding: 32px;
    height: 100%;
    width: 100%;
    box-sizing: border-box;
}
</style>
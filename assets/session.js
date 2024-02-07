import {computed, ref} from "vue";
import axios from "axios";

const sessionIsValid = ref(false);
const sessionInfo = ref({});
const sessionRole = ref(null);

try {
    const response = await axios.get('https://referral.free.beeceptor.com/.well-known/bff-sessioninfo');
    sessionInfo.value = response.data;
    sessionIsValid.value = true;
    sessionRole.value = response.data.roles[0];
} catch (error) {
    console.error('Errore nel recupero della session info:', error);
    sessionIsValid.value = true;
}

export function useSession() {
    return {
        sessionInfo: computed(() => sessionInfo.value),
        sessionIsValid: computed( () => sessionIsValid.value),
        sessionRole: computed( () => sessionRole.value),
    }
}
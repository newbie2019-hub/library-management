import { ROUTE } from "@/@types/routes";
import { RESPONSE } from "@/@types/status";
import router from "@/router";
import axios from "axios";
import { toast } from "vue-sonner";

export const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  withCredentials: true,
  withXSRFToken: true,
  headers: {
    'Accept': 'application/json'
  }
})

api.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  const status = error.response.status
  // Any status codes that falls outside the range of 2xx cause this function to trigger
  // Do something with response error
  if (status === RESPONSE.UNPROCESSABLE_ENTITY) {
    toast.error(error.response.data.message)
  }

  if (status === RESPONSE.UNAUTHENTICATED) {
    toast.error('Please login to continue')
    localStorage.removeItem('user')
    return router.replace({ name: ROUTE.LOGIN })
  }

  return error.response
});
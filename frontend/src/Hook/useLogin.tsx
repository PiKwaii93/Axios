import axios from "axios";
import {LoginResponseInterface} from "../Interface/ResponsesInterfaces";

export default function useLogin() {
    return (username: string, password: string): Promise<LoginResponseInterface> => {
        return axios({
            url: "http://localhost:2345/login.php",
            method:"get",
            withCredentials: true,
            headers: {
                Authorization: `Basic ${btoa(username + ':' + password)}`
            }
        })
        .then(res=>res.data)
    }
}

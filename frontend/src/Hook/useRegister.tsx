import axios from "axios";
import {LoginResponseInterface} from "../Interface/ResponsesInterfaces";

/*
const requestUseRegister = (username, password) => {
    axios({
        url: 'http://localhost:2345/register.php',
        withCredentials: true,
        auth: {
            username: username,
            password: password
        }
    })
        .then(res => res.data)
        .then(data => {
            setReturnUsername(data.auth);
            setReturnPassword(data.pwd);
        });
};

const signIn = (username: string, password: string) => {
    return axios.get('http://localhost:8245/register.php', 
        {
            withCredentials: true,
            auth: {
                username: username,
                password: password
            }
        }
    )
        .then(response => response.data)
        .catch(error => 'login_error')
};

const AxiosInstance = axios.create({baseURL: 'http://localhost:2345'});

AxiosInstance.get("/register.php")
.then(r => console.log(r.data))

axios.interceptors.response.use(
    response =>console.log(response.data),
    error => console.log(error)
) 

axios.interceptors.request.use(
    req => {
        console.log("J'intercepte toutes les requêtes");
        return req
    },
    err => console.log(err)
) */

export default function useRegister() {

    return (username: string, password: string): Promise<LoginResponseInterface> => {
        return axios({
            url: "http://localhost:2345/register.php",
            method:"post",
            data: new URLSearchParams({
                username : username,
                password: password
            }),
            withCredentials: true,
            auth: {
                username: username,
                password: password
            }
        })
        .then(res=>res.data)
    }
}

import {BlogInterface} from "../Interface/ResponsesInterfaces";

export default function useGetBlogList() {
    return (): Promise<BlogInterface[]> => {
        return axios({
            url: "http://localhost:2345/",
            method:"get",
        })
        .then(res=>res.data)
        }
}

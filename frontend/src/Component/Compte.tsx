
export default function Compte({username, role, id, token}) {
    return (
        <div className='p-5'>
            <h1>{username}</h1>
            <h2>{role}</h2>
            <h3>{id}</h3>
            <h4>{token}</h4>
        </div>
    )
}

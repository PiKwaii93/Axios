
export default function Compte({role}) {

    if(role=="admin"){
        return(
            <div>
                <h1>Vous avez accès à cette zone en tant qu'{role} !</h1>
            </div>
        )
    }else if(role=="user"){
        return (
            <div className='p-5'>
                <h2>En tant que {role} vous ne pouvez pas accéder à cette zone. Vous avez besoins des droits d'aministrateurs.</h2>
            </div>
        )
    }else{
        return(
            <></>
        )
    }
}

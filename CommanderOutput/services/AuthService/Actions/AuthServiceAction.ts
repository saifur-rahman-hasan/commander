import BaseAction from "@/core/BaseAction";

export default class AuthServiceAction extends BaseAction {
    async execute(data?: any) {
        try {
            let resolvedData: any = null

            return Promise.resolve(resolvedData)
        }catch (e: any){
            return Promise.reject(e)
        }
    }
}

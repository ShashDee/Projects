using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace TFNValidatorApp.Api.Services
{
    public interface IStoreValidationAttemptsService
    {
        List<string> GetValidationAttemptsIn30Secs(string tfn);
    }
}

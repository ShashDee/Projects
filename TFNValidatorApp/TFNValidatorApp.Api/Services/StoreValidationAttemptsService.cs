using System;
using System.Collections.Generic;

namespace TFNValidatorApp.Api.Services
{
    public class StoreValidationAttemptsService : IStoreValidationAttemptsService
    {
        private Dictionary<DateTime, string> validationAttempts = new Dictionary<DateTime, string>();
        private static readonly int cutOffTimeDurationSeconds = 30;

        public List<string> GetValidationAttemptsIn30Secs(string tfn)
        { 
            foreach (KeyValuePair<DateTime, string> attempt in validationAttempts)
            {
                if((DateTime.Now - attempt.Key).TotalSeconds >= cutOffTimeDurationSeconds)
                    validationAttempts.Remove(attempt.Key);
            }

            if (tfn != null && tfn != "")
                validationAttempts.Add(DateTime.Now, tfn);

            return new List<string>(validationAttempts.Values);
        }
    }
}

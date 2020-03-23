using System.Collections.Generic;
using System.Linq;

namespace TFNValidatorApp.Application.TFN.Validators
{
    public class LinkedAttemptsValidator : ILinkedAttemptsValidator
    {
        private static readonly int patternExtractorCutOff = 3;
        private static readonly int substringLength = 4;
        private static readonly int LinkedAttemptsCutffOff = 2;

        public bool CheckForLinkedValidationAttempts(List<string> validationAttempts)
        {
            List<string> substrings = new List<string>();
            int linkedCount = 0;

            for(int i = 0; i < validationAttempts.Count; i++)
            {
                List<string> currentSubstrings = PatternExtractor(validationAttempts[i]);
                
                if(substrings.Intersect(currentSubstrings).Any())
                    linkedCount++;

                substrings.AddRange(currentSubstrings);

                if (linkedCount >= LinkedAttemptsCutffOff)
                    break;
            }

            return linkedCount >= LinkedAttemptsCutffOff ? true : false;
        }

        private List<string> PatternExtractor(string attempt)
        {
            List<string> attemptSubstrings = new List<string>();

            for (int i = 0; i < attempt.Length - patternExtractorCutOff; i++)
            {
                if (!attemptSubstrings.Contains(attempt.Substring(i, substringLength)))
                    attemptSubstrings.Add(attempt.Substring(i, substringLength));
            }

            return attemptSubstrings;
        }
    }
}

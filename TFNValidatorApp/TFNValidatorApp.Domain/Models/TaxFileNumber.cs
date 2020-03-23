using System;
using System.Collections.Generic;
using System.Text;

namespace TFNValidatorApp.Domain.Models
{
    public class TaxFileNumber
    {
        public string TFN { get; set; }

        protected TaxFileNumber() { }

        public TaxFileNumber(string tfn)
        {
            TFN = tfn;
        }
    }
}

using System;
using System.Threading.Tasks;
using System.Threading;
using MediatR;
using Ordering.Domain.Models;
using Ordering.Domain.Models.ProductAggregate;

namespace Ordering.Api.Application.Commands
{
    public class AddProductCommandHandler : IRequestHandler<AddProductCommand, Guid>
    {
        private readonly IRepository<Product> _productRepository;

        public AddProductCommandHandler(IRepository<Product> productRepository)
        {
            _productRepository = productRepository ?? throw new ArgumentNullException(nameof(productRepository));
        }

        public async Task<Guid> Handle(AddProductCommand request, CancellationToken cancellationToken)
        {
            var product = _productRepository.Add(new Product(request.Name, request.Description, request.Price));

            await _productRepository.UnitOfWork.SaveEntitiesAsync();
            return product.Id;
        }
    }
}

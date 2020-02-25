using System;
using System.Threading.Tasks;
using System.Threading;
using MediatR;
using Ordering.Domain.Models;
using Ordering.Domain.Models.OrderAggregate;
using Ordering.Domain.Models.ProductAggregate;
using Ordering.Domain.Exceptions;

namespace Ordering.Api.Application.Commands
{
    public class AddOrderCommandHandler : IRequestHandler<AddOrderCommand, Guid>
    {
        private readonly IRepository<Order> _orderRepository;
        private readonly IRepository<Product> _productRepository;

        public AddOrderCommandHandler(IRepository<Order> orderRepository, IRepository<Product> productRepository)
        {
            _orderRepository = orderRepository ?? throw new ArgumentNullException(nameof(orderRepository));
            _productRepository = productRepository ?? throw new ArgumentNullException(nameof(productRepository));
        }

        public async Task<Guid> Handle(AddOrderCommand request, CancellationToken cancellationToken)
        {
            var product = _productRepository.GetAsync(request.ProductId);

            if(product == null)
                throw new OrderDomainException("The order product does not exist.");

            var order = _orderRepository.Add(new Order(request.ProductId, request.OrderDate, request.Description));

            await _orderRepository.UnitOfWork.SaveEntitiesAsync();
            return order.Id;
        }
    }
}
